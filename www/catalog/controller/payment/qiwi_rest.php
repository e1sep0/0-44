<?php
class ControllerPaymentQiwiRest extends Controller {
	protected function index() {
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');


		$this->data['action'] = 'https://w.qiwi.com/order/external/main.action';

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);


		$this->load->language('payment/qiwi_rest');
		$this->data['sub_text_info'] = $this->language->get('sub_text_info');
		$this->data['sub_text_info_phone'] = $this->language->get('sub_text_info_phone');

		$this->data['qiwi_rest_limit'] = $this->language->get('qiwi_rest_limit');
		$this->data['button_back'] = $this->language->get('button_back');

            $this->data['description'] = $this->config->get('config_store') . ' ' . $this->language->get('order_id') . $order_info['order_id'];

		// Переменные
		$this->data['shop'] = $this->config->get('qiwi_rest_shop_id');
		$this->data['transaction'] = $this->session->data['order_id'];

		$this->data['successUrl'] = $this->url->link('payment/qiwi_rest/success'); 
		$this->data['failUrl'] =  $this->url->link('payment/qiwi_rest/fail');
		
		$ccy_code = $this->config->get('qiwi_rest_ccy_select');
		$ccy_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $ccy_code);
		$this->data['summ'] = $this->currency->format($ccy_order_total, $ccy_code, $order_info['currency_value'], FALSE);
		$this->data['summ'] = round((float)$this->data['summ'] + (float)$this->data['summ']/100*(float)$this->config->get('qiwi_rest_markup'), 2);
		$this->data['ccy'] = $ccy_code;


		$this->data['phone'] = preg_replace("/\D+/", "", $order_info['telephone']);
		//if (strlen ($this->data['phone']) > 10) $this->data['phone'] = substr($this->data['phone'], -10);

		$this->data['return'] = $this->url->link('checkout/success', '', 'SSL');

		$products = $this->cart->getProducts();
		$_prods = "";
		foreach ($products as $product) 
		{ 
			if ($_prods == "")
				$_prods = $_prods . $product['name'] . " - " . $product['quantity'] . " шт ";
			else
				$_prods = $_prods . ',' . $product['name'] . " - " . $product['quantity'] . " шт ";

		} 
		$_prods = " [ " . $_prods . " ] ";


		if (mb_strlen($_prods,'UTF-8')>255) $_prods = mb_substr($_prods, 0, 252, 'UTF-8').'...';
		$_prods = $this->data['description'] . $_prods;

		$this->data['com'] = html_entity_decode($_prods, ENT_QUOTES, 'UTF-8');

		$this->data['markup'] = sprintf ($this->language->get('markup'), $this->config->get('qiwi_rest_markup')).$this->data['summ'].' '.$this->config->get('qiwi_rest_ccy_select'); 

		$this->id = 'payment';


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/qiwi_rest.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/qiwi_rest.tpl';
		} else {
			$this->template = 'default/template/payment/qiwi_rest.tpl';
		}

		$this->render();
	}

	public function confirm() {

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		if(!$order_info) return ;

		$order_id = $this->session->data['order_id'];

		if( $order_info['order_status_id'] == 0) {
			$this->model_checkout_order->confirm($order_id, $this->config->get('qiwi_rest_order_status_progress_id'), 'qiwi_rest');
		}
		else
		if( $order_info['order_status_id'] != $this->config->get('qiwi_rest_order_status_progress_id')) {
			$this->model_checkout_order->update($order_id, $this->config->get('qiwi_rest_order_status_progress_id'),'qiwi_rest',TRUE);
		}


		$service_url = 'https://w.qiwi.com/api/v2/prv/' . $this->config->get('qiwi_rest_shop_id') . '/bills/' . $order_id;
		$ch = curl_init($service_url);

		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
    		curl_setopt($ch, CURLOPT_USERPWD, $this->config->get('qiwi_rest_id') . ":" . $this->config->get('qiwi_rest_password'));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	    	curl_setopt($ch, CURLOPT_HTTPHEADER, array (
		    "Accept: application/json"
    		));


		$ccy_code = $this->config->get('qiwi_rest_ccy_select');
		$ccy_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $ccy_code);
		$summ = $this->currency->format($ccy_order_total, $ccy_code, $order_info['currency_value'], FALSE);
		$summ = round((float)$summ + (float)$summ/100*(float)$this->config->get('qiwi_rest_markup'), 2);

		$objDateTime = new DateTime('NOW');
		$objDateTime->add(new DateInterval('PT'.$this->config->get('qiwi_rest_lifetime').'H'));		
		$qiwi_rest_order_end_time = $objDateTime->format(DateTime::ISO8601);

		$_data = "user=" . urlencode("tel:" . $this->request->post['qiwi_phone']) . "&amount=" . urlencode($summ) . "&ccy=" . urlencode($ccy_code) . "&comment=" . urlencode($this->request->post['qiwi_com']) . "&lifetime=" . urlencode($qiwi_rest_order_end_time);

//$this->log->write('1= '. $_data);
//$_data = "user=tel%3A%2B79263076944&amount=10.0&ccy=RUB&comment=test&lifetime=2013-11-25T09%3A00%3A00";

		if ($this->config->get('qiwi_rest_mode_select')=='qiwi_rest_mode_debug')
		{
			$this->log->write('qiwi_rest _order ' . $_data);
		}


		curl_setopt($ch, CURLOPT_POSTFIELDS, $_data);

		$curl_response = curl_exec($ch);
		if ($curl_response === false) {
		    $info = curl_error($ch);
		    curl_close($ch);
		    $this->log->write('qiwi_rest error ' .  $info);
		    return ; 
		}
		curl_close($ch);
		$decoded = json_decode($curl_response);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		     $this->log->write('qiwi_rest ' . 'error occured: ' . $decoded->response->errormessage);
		     return;
		}

		//var_export($decoded->response);

		if ($this->config->get('qiwi_rest_mode_select')=='qiwi_rest_mode_debug')
		{
			$this->log->write('qiwi_rest order ' . ' ' . print_r($decoded->response, true));
		}

		return ;

   	}

	public function fail() {

		$this->redirect($this->url->link('checkout/payment', '' , 'SSL'));

		return TRUE;
	}

	public function success() {

		$this->redirect($this->url->link('checkout/success', '' , 'SSL'));

		return TRUE;
	}


	private function sendAnswer($error) {
		    	$x = '<?xml version="1.0"?>';
		    	$x .= '<result>';
		    	$x .= '<result_code>'.$error.'</result_code>';
		    	$x .= '</result>';

			header ("HTTP/1.1 200 OK");
			header ("Content-Type: text/xml" , false); 
			echo($x);

//$this->log->write('qiwi_rest order5 ' . ' ' .$x);
	}


	private function cidr_match($ip, $cidr)
	{
	    list($subnet, $mask) = explode('/', $cidr);
	
	    if ((ip2long($ip) & ~((1 << (32 - $mask)) - 1) ) == ip2long($subnet))
	    { 
	        return true;
	    }
	
	    return false;
	}

	public function callback() {

		if ($this->config->get('qiwi_rest_mode_select')=='qiwi_rest_mode_debug')
		{
			$this->log->write('qiwi_rest callback order ' . ' ' .http_build_query($this->request->post));
		}

		$in = $this->cidr_match($_SERVER["REMOTE_ADDR"], "91.232.230.0/23");
		if ($in == false) $in = $this->cidr_match($_SERVER["REMOTE_ADDR"], "79.142.16.0/20");

		if ($in == false)
		{
			$this->log->write('qiwi_rest attack ' . $_SERVER["REMOTE_ADDR"]);
			$this->sendAnswer(5);
			exit;
		}

		if (isset($this->request->post['command'])) {
			$command = $this->request->post['command'];
		} else {
			$this->sendAnswer(5);
			exit;
		}

		if ($command != 'bill')
		{
			$this->sendAnswer(5);
			exit;
		}

		if (isset($this->request->post['bill_id'])) {
			$bill_id = $this->request->post['bill_id'];
		} else {
			$this->sendAnswer(5);
			exit;
		}

		if (isset($this->request->post['status'])) {
			$status = $this->request->post['status'];
		} else {
			$this->sendAnswer(5);
			exit;
		}

		if (isset($this->request->post['error'])) {
			$error = $this->request->post['error'];
		} else {
			$this->sendAnswer(5);
			exit;
		}

		if (isset($this->request->post['amount'])) {
			$amount = $this->request->post['amount'];
		} else {
			$this->sendAnswer(5);
			exit;
		}


		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($bill_id);
		if(!$order_info) 
		{
			$this->sendAnswer(210);
			exit;
		}


		// Статус проведения счета.
		if( $status == 'paid' ) {

			if( $order_info['order_status_id'] == 0) {
				$this->model_checkout_order->confirm($bill_id, $this->config->get('qiwi_rest_order_status_id'), 'qiwi_rest');
				return $param;
			}

			if( $order_info['order_status_id'] != $this->config->get('qiwi_rest_order_status_id')) {
				$this->model_checkout_order->update($bill_id, $this->config->get('qiwi_rest_order_status_id'),'qiwi_rest',TRUE);
			}
		} elseif( $status == 'waiting') {

			if( $order_info['order_status_id'] == 0) {
				$this->model_checkout_order->confirm($bill_id, $this->config->get('qiwi_rest_order_status_progress_id'), 'qiwi_rest');
				return $param;
			}

			if( $order_info['order_status_id'] != $this->config->get('qiwi_rest_order_status_progress_id')) {
				$this->model_checkout_order->update($bill_id, $this->config->get('qiwi_rest_order_status_progress_id'),'qiwi_rest',TRUE);
			}

		} else {

			if( $order_info['order_status_id'] == 0) {
				$this->model_checkout_order->confirm($bill_id, $this->config->get('qiwi_rest_order_status_cancel_id'), 'qiwi_rest');
				return $param;
			}

			if( $order_info['order_status_id'] != $this->config->get('qiwi_rest_order_status_cancel_id')) {
				$this->model_checkout_order->update($bill_id, $this->config->get('qiwi_rest_order_status_cancel_id'),'qiwi_rest',TRUE);
			}

		}


		$this->sendAnswer(0);

	}


}
?>