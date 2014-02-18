<?php
class ControllerTotalSocialDiscount extends Controller {
	public function index() {
		if(isset($this->request->post['product_id']) && isset($this->request->post['event'])) {

			if($this->request->post['event'] == 'like') {
				$this->session->data['socialdiscount'][$this->request->post['product_id']]['like'] = true;
			}

			if($this->request->post['event'] == 'unlike') {
				unset($this->session->data['socialdiscount'][$this->request->post['product_id']]['like']);
			}
			if($this->request->post['event'] == 'shared') {
				$this->session->data['socialdiscount'][$this->request->post['product_id']]['shared'] = true;
			}

			if($this->request->post['event'] == 'unshared') {
				unset($this->session->data['socialdiscount'][$this->request->post['product_id']]['unshared']);
			}
		}
	}
}
?>