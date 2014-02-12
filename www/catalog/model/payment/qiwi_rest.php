<?php 
class ModelPaymentQiwiRest extends Model {
  	public function getMethod($address) {
		$this->load->language('payment/qiwi_rest');
		
		if ($this->config->get('qiwi_rest_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('qiwi_rest_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
			if (!$this->config->get('qiwi_rest_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
      		  	$status = TRUE;
      		} else {
     	  		$status = FALSE;
			}	
      	} else {
			$status = FALSE;
		}
		

		$method_data = array();
	
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl') . 'image/';
		} else {
			$server = $this->config->get('config_url') . 'image/';
		}	

		if ($status) {  
      		$method_data = array( 
        		'code'       => 'qiwi_rest',
        		'title'      => $this->config->get('qiwi_rest_mode_show_picture')=='qiwi_rest_show_picture_on'?'<img src="'.$server.'payment/QIWI.png" style="vertical-align:middle;"> '.$this->language->get('text_title') : $this->language->get('text_title'),
			'sort_order' => $this->config->get('qiwi_rest_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>