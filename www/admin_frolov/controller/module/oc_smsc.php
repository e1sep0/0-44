<?php

class ControllerModuleOCSMSC extends Controller
{
	public $order_statuses, $status_id_message;

	public function index()
	{
		$this->_init();

		// If form is posted & receiving data is valid
		if (count($this->request->post) && isset($this->request->post['setting_form'])) {
			// Settings update
			isset($this->request->post['setting_form']);

			// Remove form id from DB config
			unset($this->request->post['setting_form']);

			// Save changes to DB
			$this->model_setting_setting->editSetting('oc_smsc', $this->request->post);

			// Redirect into the main page
			$this->redirect($this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL'));
		}

		$this->_view();
	}

	private function _breadcrumbs()
	{
		$breadcrumbs[] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token='.$this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$breadcrumbs[] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$breadcrumbs[] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/oc_smsc', 'token='.$this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		return $breadcrumbs;
	}

	private function _init()
	{
		// Load gateway library
		require_once(DIR_SYSTEM.'library/oc_smsc/gateway.php');

		// Load settings
		$this->load->model('setting/setting');

		// Load multilanguage language tools
		$this->load->model('localisation/language');

		// Load language
		foreach ($this->load->language('module/oc_smsc') as $key => $value)
			$this->data[$key] = $value;

		// Get saved values
		$setting = $this->model_setting_setting->getSetting('oc_smsc');

		// Set by default form_values
		foreach ($setting as $key => $value)
			$this->data['value_'.$key] = $value;
	}

	private function _view()
	{
		// Set title
		$this->document->setTitle($this->language->get('heading_title'));

		// Set view variables
		$this->data['breadcrumbs'] = $this->_breadcrumbs();

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->data['url_action'] = $this->url->link('module/oc_smsc', 'token='.$this->session->data['token'], 'SSL');
		$this->data['url_cancel'] = $this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL');

		// If we have a new form values from request
		foreach ($this->request->post as $key => $value)
			$this->data['value_'.$key] = $value;

		// Get all statuses from database oc_smsc
		$this->order_statuses = $this->db->query("SELECT order_status_id,name FROM `" . DB_PREFIX . "order_status` WHERE language_id = ".$this->config->get('config_language_id'));

		// Get messages for all statuses oc_smsc
		$this->status_id_message = $this->db->query("SELECT `key`,`value` FROM `" . DB_PREFIX . "setting` WHERE `key` LIKE 'oc_smsc_status_id_%'");

		// Template rendering
		$this->children = array('common/header', 'common/footer');
		$this->template = 'module/oc_smsc.tpl';

		$this->response->setOutput($this->render());
	}
}
