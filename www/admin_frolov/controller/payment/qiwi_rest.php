<?php
class ControllerPaymentQiwiRest extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/qiwi_rest');
		$this->data['qiwi_rest_version'] = '2.3.2';	

		$this->document->setTitle = $this->language->get('heading_title');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('qiwi_rest', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));

		}

		$this->data['heading_title'] = $this->language->get('heading_title');


		$this->data['entry_shop_id'] = $this->language->get('entry_shop_id');
		$this->data['entry_rest_id'] = $this->language->get('entry_rest_id');

		$this->data['entry_rest_password'] = $this->language->get('entry_rest_password');
		$this->data['entry_ccy_en'] = $this->language->get('entry_ccy_en');
		$this->data['entry_ccy_select'] = $this->language->get('entry_ccy_select');

		$this->data['entry_markup'] = $this->language->get('entry_markup');

		$this->data['entry_qiwi_rest_mode'] = $this->language->get('entry_qiwi_rest_mode');

		$this->data['entry_qiwi_rest_modes'][] = array('code'=>'qiwi_rest_mode_normal', 'code_text'=>$this->language->get('entry_qiwi_rest_mode_normal'));
		$this->data['entry_qiwi_rest_modes'][] = array('code'=>'qiwi_rest_mode_debug', 'code_text'=>$this->language->get('entry_qiwi_rest_mode_debug'));


		$this->data['entry_qiwi_rest_show_picture'] = $this->language->get('entry_qiwi_rest_show_picture');

		$this->data['entry_qiwi_rest_modes_show_picture'][] = array('code'=>'qiwi_rest_show_picture_on', 'code_text'=>$this->language->get('entry_qiwi_rest_show_picture_on'));
		$this->data['entry_qiwi_rest_modes_show_picture'][] = array('code'=>'qiwi_rest_show_picture_off', 'code_text'=>$this->language->get('entry_qiwi_rest_show_picture_off'));
	


		$this->data['entry_result_url'] = $this->language->get('entry_result_url');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');

		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_order_status_cancel'] = $this->language->get('entry_order_status_cancel');
		$this->data['entry_order_status_progress'] = $this->language->get('entry_order_status_progress');
		$this->data['entry_lifetime'] = $this->language->get('entry_lifetime');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['shop_id'])) {
			$this->data['error_shop_id'] = $this->error['shop_id'];
		} else {
			$this->data['error_shop_id'] = '';
		}

		if (isset($this->error['rest_id'])) {
			$this->data['error_rest_id'] = $this->error['rest_id'];
		} else {
			$this->data['error_rest_id'] = '';
		}


		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['lifetime'])) {
			$this->data['error_lifetime'] = $this->error['lifetime'];
		} else {
			$this->data['error_lifetime'] = '';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/qiwi_rest', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/qiwi_rest', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/currency');
		$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();

		// Номер магазина
		if (isset($this->request->post['qiwi_rest_shop_id'])) {
			$this->data['qiwi_rest_shop_id'] = $this->request->post['qiwi_rest_shop_id'];
		} else {
			$this->data['qiwi_rest_shop_id'] = $this->config->get('qiwi_rest_shop_id');
		}

		if (isset($this->request->post['qiwi_rest_id'])) {
			$this->data['qiwi_rest_id'] = $this->request->post['qiwi_rest_id'];
		} else {
			$this->data['qiwi_rest_id'] = $this->config->get('qiwi_rest_id');
		}


		if (isset($this->request->post['qiwi_rest_password'])) {
			$this->data['qiwi_rest_password'] = $this->request->post['qiwi_rest_password'];
		} else {
			$this->data['qiwi_rest_password'] = $this->config->get('qiwi_rest_password');
		}

		// URL
		$this->data['qiwi_rest_result_url'] 	= HTTP_CATALOG . 'index.php?route=payment/qiwi_rest/callback';
		$this->data['qiwi_rest_success_url'] = HTTP_CATALOG . 'index.php?route=payment/qiwi_rest/success';
		$this->data['qiwi_rest_fail_url'] 		= HTTP_CATALOG . 'index.php?route=payment/qiwi_rest/fail';


		if (isset($this->request->post['qiwi_rest_order_status_id'])) {
			$this->data['qiwi_rest_order_status_id'] = $this->request->post['qiwi_rest_order_status_id'];
		} else {
			$this->data['qiwi_rest_order_status_id'] = $this->config->get('qiwi_rest_order_status_id');
		}

		if (isset($this->request->post['qiwi_rest_order_status_cancel_id'])) {
			$this->data['qiwi_rest_order_status_cancel_id'] = $this->request->post['qiwi_rest_order_status_cancel_id'];
		} else {
			$this->data['qiwi_rest_order_status_cancel_id'] = $this->config->get('qiwi_rest_order_status_cancel_id');
		}

		if (isset($this->request->post['qiwi_rest_order_status_progress_id'])) {
			$this->data['qiwi_rest_order_status_progress_id'] = $this->request->post['qiwi_rest_order_status_progress_id'];
		} else {
			$this->data['qiwi_rest_order_status_progress_id'] = $this->config->get('qiwi_rest_order_status_progress_id');
		}

		if (isset($this->request->post['qiwi_rest_lifetime'])) {
			$this->data['qiwi_rest_lifetime'] = (int)$this->request->post['qiwi_rest_lifetime'];
		} elseif( $this->config->get('qiwi_rest_lifetime') ) {
			$this->data['qiwi_rest_lifetime'] = (int)$this->config->get('qiwi_rest_lifetime');
		} else {
			$this->data['qiwi_rest_lifetime'] = 24;
		}


		if (isset($this->request->post['qiwi_rest_markup'])) {
			$this->data['qiwi_rest_markup'] = $this->request->post['qiwi_rest_markup'];
		} elseif( $this->config->get('qiwi_rest_markup') ) {
			$this->data['qiwi_rest_markup'] = $this->config->get('qiwi_rest_markup');
		} else {
			$this->data['qiwi_rest_markup'] = 0.0;
		}


		if (isset($this->request->post['qiwi_rest_ccy_select'])) {
			$this->data['qiwi_rest_ccy_select'] = $this->request->post['qiwi_rest_ccy_select'];
		} elseif( $this->config->get('qiwi_rest_ccy_select') ) {
			$this->data['qiwi_rest_ccy_select'] = $this->config->get('qiwi_rest_ccy_select');
		} else {
			$this->data['qiwi_rest_ccy_select'] = 'RUB';
		}


		// Проверка на наличие SOAP сервера
		if( class_exists('SoapServer') ) {
			$this->data['flag_soap'] = 1;
		} else {
			$this->data['flag_soap'] = 0;
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['qiwi_rest_geo_zone_id'])) {
			$this->data['qiwi_rest_geo_zone_id'] = $this->request->post['qiwi_rest_geo_zone_id'];
		} else {
			$this->data['qiwi_rest_geo_zone_id'] = $this->config->get('qiwi_rest_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['qiwi_rest_status'])) {
			$this->data['qiwi_rest_status'] = $this->request->post['qiwi_rest_status'];
		} else {
			$this->data['qiwi_rest_status'] = $this->config->get('qiwi_rest_status');
		}

		if (isset($this->request->post['qiwi_rest_sort_order'])) {
			$this->data['qiwi_rest_sort_order'] = $this->request->post['qiwi_rest_sort_order'];
		} else {
			$this->data['qiwi_rest_sort_order'] = $this->config->get('qiwi_rest_sort_order');
		}

		if (isset($this->request->post['qiwi_rest_mode_select'])) {
			$this->data['qiwi_rest_mode_select'] = $this->request->post['qiwi_rest_mode_select'];
		} else {
			$this->data['qiwi_rest_mode_select'] = $this->config->get('qiwi_rest_mode_select');
		}

		if (isset($this->request->post['qiwi_rest_mode_show_picture'])) {
			$this->data['qiwi_rest_mode_show_picture'] = $this->request->post['qiwi_rest_mode_show_picture'];
		} else {
			$this->data['qiwi_rest_mode_show_picture'] = $this->config->get('qiwi_rest_mode_show_picture');
		}

		$this->template = 'payment/qiwi_rest.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/qiwi_rest')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}


		// TODO проверку на валидность номера!
		if (!$this->request->post['qiwi_rest_shop_id']) {
			$this->error['shop_id'] = $this->language->get('error_shop_id');
		}

		if (!$this->request->post['qiwi_rest_id']) {
			$this->error['rest_id'] = $this->language->get('error_rest_id');
		}

		if (!$this->request->post['qiwi_rest_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>