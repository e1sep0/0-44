<?php
class ControllerModuleWebmeCategoriesAtHomepage extends Controller {
	protected function index($setting) {
		$this->id = 'webme_categories_at_homepage';
		
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		/* ===================================== */
		
		$this->load->model('catalog/category');
		
		$category_ids = explode("_", $this->config->get('webme_categories_at_homepage_category'));
		foreach ($category_ids as $cat_id) {
			$category_id = $cat_id;
			$category_info = $this->model_catalog_category->getCategory($category_id);
			
			if ($category_info) {
				$this->data['w_categories'][$category_id]['heading_title'] = $category_info['name'];
				$this->data['w_categories'][$category_id]['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
				$this->data['w_categories'][$category_id]['href'] = $this->url->link('product/category', 'path='.$category_id);
				
				$this->load->model('tool/image');
				
				if ($category_info['image']) {
					$image = $category_info['image'];
				} else {
					$image = '';
				}
				
				$this->data['w_categories'][$category_id]['thumb'] = $this->model_tool_image->resize($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				
				$this->load->model('catalog/webme_categories_at_homepage');
				$this->load->model('catalog/product');
				$this->load->model('catalog/review');
				
				$product_total = $this->model_catalog_webme_categories_at_homepage->getTotalProductsByCategoryId($category_id);
				
				if ($product_total) {
					$this->data['w_categories'][$category_id]['button_add_to_cart'] = $this->language->get('button_add_to_cart');
					$this->data['w_categories'][$category_id]['products'] = array();
					
					$w_sort_order = explode("-", $this->config->get('webme_categories_at_homepage_sort_by'));
					$sort = $w_sort_order["0"];
					$order = $w_sort_order["1"];
					
					$wProdLimit = $this->config->get('webme_categories_at_homepage_limit');
					
					$data = array(
						'filter_category_id' => $category_id, 
						'sort'               => $sort,
						'order'              => $order,
						'start'              => 0,
						'limit'              => 4
					);
					if ($wProdLimit > 0) {
						if ($this->config->get('webme_categories_at_homepage_limit') > 0) {
							$data['limit'] = $this->config->get('webme_categories_at_homepage_limit');
						}
						$results = $this->model_catalog_product->getProducts($data);
					} else {
						$results = $this->model_catalog_product->getProducts($data);
					}
					
        			foreach ($results as $result) {
					if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}
					
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}
					
					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}
					
					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}
					
					$options = $this->model_catalog_product->getProductOptions($result['product_id']);
					
					if ($options) {
						$add = $this->url->link('product/product', 'path='.$category_id.'&product_id='.$result['product_id']);
					} else {
						$add = $this->url->link('checkout/cart', 'product_id='.$result['product_id']);
					}
					
					$this->data['w_categories'][$category_id]['products'][] = array(
						'product_id'    => $result['product_id'],
						'name'    => $result['name'],
						'model'   => $result['model'],
						'rating'  => $rating,
						'stars'   => sprintf($this->language->get('text_stars'), $rating),
						'thumb'   => $this->model_tool_image->resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
						'price'   => $price,
						'options' => $options,
						'special' => $special,
						'href'    => $this->url->link('product/product', 'path='.$category_id.'&product_id='.$result['product_id']),
						'add'	  => $add
					);
				}
				
				if (!$this->config->get('config_customer_price')) {
					$this->data['w_categories'][$category_id]['display_price'] = TRUE;
				} elseif ($this->customer->isLogged()) {
					$this->data['w_categories'][$category_id]['display_price'] = TRUE;
				} else {
					$this->data['w_categories'][$category_id]['display_price'] = FALSE;
				}
			}
		}
		/* ===================================== */
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/webme_categories_at_homepage.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/webme_categories_at_homepage.tpl';
		} else {
			$this->template = 'default/template/module/webme_categories_at_homepage.tpl';
		}
		$this->render();
	}
	}
}
?>