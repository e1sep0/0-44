<?php
class ControllerPaymentYandexTransfer extends Controller {
	protected function index() {
		$this->language->load('payment/yandex_transfer');

		$this->data['text_instruction'] = $this->language->get('text_instruction');
		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_instruction_2'] = str_replace('{server}', HTTPS_SERVER, $this->language->get('text_instruction_2'));
		$this->data['text_instruction_3'] = $this->language->get('text_instruction_3');
		$this->data['text_payment'] = $this->language->get('text_payment');
         $this->data['text_printpay'] = $this->language->get('text_printpay');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['bank'] = nl2br($this->config->get('yandex_transfer_bank_' . $this->config->get('config_language_id')));

		$this->data['continue'] = $this->url->link('checkout/success');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/yandex_transfer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/yandex_transfer.tpl';
		} else {
			$this->template = 'default/template/payment/yandex_transfer.tpl';
		}

		$this->render();
	}


    public function printpay() {

	$this->load->model('checkout/order');

		$this->language->load('payment/yandex_transfer');

		$this->data['text_instruction'] = $this->language->get('text_instruction');
		$this->data['text_payment'] = $this->language->get('text_payment');

		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['bank'] = nl2br($this->config->get('yandex_transfer_bank_' . $this->config->get('config_language_id')));
		$this->data['inn'] = nl2br($this->config->get('yandex_transfer_inn_' . $this->config->get('config_language_id')));
		$this->data['rs'] = nl2br($this->config->get('yandex_transfer_rs_' . $this->config->get('config_language_id')));
		$this->data['bankuser'] = nl2br($this->config->get('yandex_transfer_bankuser_' . $this->config->get('config_language_id')));
		$this->data['bik'] = nl2br($this->config->get('yandex_transfer_bik_' . $this->config->get('config_language_id')));
		$this->data['ks'] = nl2br($this->config->get('yandex_transfer_ks_' . $this->config->get('config_language_id')));



		$this->load->model('account/order');


		if (isset($this->request->get['order_id'])) {

		$this->document->breadcrumbs = array();
		$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=payment/yandex_transfer/printpay&order_id=' . $this->request->get['order_id'],
        	'text'      => $this->language->get('text_invoice'),
        	'separator' => $this->language->get('text_separator')
      										);

			$order_id = $this->request->get['order_id'];

		} else {

			$order_id = '';

		}

		if ($order_id == ''){
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		}else{
		$order_info = $this->model_account_order->getOrder($order_id);
		}

		$rur_code = 'RUB';
		$rur_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $rur_code);
		$this->data['amount'] = $this->currency->format($rur_order_total, $rur_code, $order_info['currency_value'], FALSE);
		$this->data['order_id'] = $order_info['order_id'];

		$this->data['name'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];

		if (!$order_info['payment_address_2']) {
			$this->data['address'] = $order_info['payment_zone'] . ', ' . $order_info['payment_city'] . ', ' .$order_info['payment_address_1'] ;
		} else {
			$this->data['address'] = $order_info['payment_zone'] . ', ' . $order_info['payment_address_2'] . ', ' . $order_info['payment_city'] . ', ' .$order_info['payment_address_1'] ;
		}

		$this->data['postcode'] = $order_info['payment_postcode'];

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/yandex_transfer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/yandex_transfer_printpay.tpl';
		} else {
			$this->template = 'default/template/payment/yandex_transfer_printpay.tpl';
		}

	$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));

	}


	public function confirm() {
		$this->language->load('payment/yandex_transfer');

        $this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$comment  = $this->language->get('text_instruction') . "\n\n";

		/*$comment .= $this->config->get('fl_yandex_bank_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_yandex_inn_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_yandex_rs_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_yandex_bankuser_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_yandex_bik_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_yandex_ks_' . $this->config->get('config_language_id')) . "\n\n";*/
		$comment .= str_replace('{server}', HTTPS_SERVER, $this->language->get('text_instruction_2')) . $this->data['order_id'] = $order_info['order_id'] .  $this->language->get('text_instruction_3') . "\n\n";
		$comment .= $this->language->get('text_payment');





		$comment  = $this->language->get('text_instruction') . "\n\n";

		$comment .= str_replace('{server}', HTTPS_SERVER, $this->language->get('text_instruction_2')) . $this->data['order_id'] = $order_info['order_id'] .  $this->language->get('text_instruction_3') . "\n\n";
		$comment .= $this->language->get('text_payment_coment');

		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('yandex_transfer_order_status_id'), $comment);
	}
}


?>