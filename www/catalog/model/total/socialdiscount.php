<?php
class ModelTotalSocialDiscount extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if(isset($this->session->data['socialdiscount'])) {
			$value = 0;
			$perc_like = false;
			$val_like = $this->config->get('socialdiscount_value_like');
			if(substr($val_like, -1) == '%') {
				$val_like = substr($val_like, 0, -1);
				$perc_like = true;
			}
			$val_like = (float)$val_like;

			$perc_share = false;
			$val_share = $this->config->get('socialdiscount_value_share');
			if(substr($val_share, -1) == '%') {
				$val_share = substr($val_share, 0, -1);
				$perc_share = true;
			}
			$val_share = (float)$val_share;

			foreach($this->cart->getProducts() as $product) {

				if(array_key_exists($product['product_id'], $this->session->data['socialdiscount']) && isset($this->session->data['socialdiscount'][$product['product_id']]['like'])) {
					if($perc_like) {
						$value -= round($product['total'] / 100 * $val_like, 2);
					} else {
						$value -= $val_like;
					}
				}

				if(array_key_exists($product['product_id'], $this->session->data['socialdiscount']) && isset($this->session->data['socialdiscount'][$product['product_id']]['shared'])) {
					if($perc_share) {
						$value -= round($product['total'] / 100 * $val_share, 2);
					} else {
						$value -= $val_share;
					}
				}
			}

			if($value < 0) {
				$this->load->language('total/socialdiscount');

				$total_data[] = array(
					'code' => 'socialdiscount',
					'title' => $this->language->get('text_social_discount'),
					'text' => $this->currency->format($value),
					'value' => $value,
					'sort_order' => $this->config->get('socialdiscount_sort_order')
				);

				$total += $value;
			}
		}
	}
}

?>