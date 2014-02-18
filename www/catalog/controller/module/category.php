<?php  
class ControllerModuleCategory extends Controller {
	protected function index($setting) {
		$this->language->load('module/category');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['category_id'] = $parts[0];
		} else {
			$this->data['category_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}
		
		if (isset($parts[2])) {  //+
			$this->data['ch3_id'] = $parts[2];
		} else {
			$this->data['ch3_id'] = 0;
		} //+

							
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);
		
		//Показывать или нет количество товаров
		$show_product_count = $this->config->get('config_product_count');

		foreach ($categories as $category) {
			//Будем вычислять кол-во товаров в категориях только если это кол-во надо показывать
			if ($show_product_count) {
				//$total = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category['category_id']));
        $total=0;
			}

			$children_data = array();

			$children = $this->model_catalog_category->getCategories($category['category_id']);

			foreach ($children as $child) {
				//Будем вычислять кол-во товаров в категориях только если это кол-во надо показывать
				if ($show_product_count) {
					$data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

				//	$product_total = $this->model_catalog_product->getTotalProducts($data);
				$level3 = $this->model_catalog_category->getCategories($child['category_id']);//+
				$l3_data = array();
				foreach ($level3 as $l3) {
					$l3_data[] = array(
						'category_id' => $l3['category_id'],
						'name'        => $l3['name'],
						'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' . $l3['category_id'])
					);
				}//+


				//	$total += $product_total;
				}

				$children_data[] = array(
					'category_id' => $child['category_id'],
					//'name'        => $child['name'] . ($show_product_count ? ' (' . $product_total . ')' : ''),
					'name'        => $child['name'], // . ' (' . $product_total . ')',
					'children'    => $l3_data,//+
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])	
				);		
			}

			$this->data['categories'][] = array(
				'category_id' => $category['category_id'],
				//'name'        => $category['name'] . ($show_product_count ? ' (' . $total . ')' : ''),
				'name'        => $category['name'], // . ' (' . $product_total . ')',
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);	
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/category.tpl';
		} else {
			$this->template = 'default/template/module/category.tpl';
		}
		
		$this->render();
  	}

}
?>