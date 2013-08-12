<?php

    class Products extends databaseObject{

        public $table = "products";
        public $idfield = "product_id";

        public $product_id;
        public $product_name;
        public $content;
        public $NM_price;
        public $M_price;
        public $I_price;
        public $featured;
        public $directLink;
        public $shipping;
        public $download;
        public $external;
       	public $type;
        public $front_page;
        public $out_of_stock;
        public $quantity;
        public $published;
        public $access;


        //Helpers
        public $category_id;
        public $productTable;
        public $price;
        public $downloadLink;





        public function __construct($p_id="") {
           if (empty($p_id)) $p_id = $this->product_id;

			if (!empty($p_id)) {
         		$result = $this->fetchById($p_id);
				$this->directLink = $this->createLink('store', $this->directLink);
				$this->category_id = $this->getCategory();
				$this->downloadLink = $this->createDownloadLink();
			}
        }



/* ========================================
	Build/Helper Methods
	==================================== */

		private function https($string) {
			return str_replace('http', 'https', $string);
		}

		public function setupMoney() {
			if (!empty($this->M_price)) $this->M_price = '$'.  money_format('%i', $this->M_price);
			if (!empty($this->NM_price)) $this->NM_price = '$'.  money_format('%i', $this->NM_price);
			if (!empty($this->I_price)) $this->I_price = '$'. money_format('%i', $this->I_price);

		}

		public function readableType() {
			switch ($this->type) {
				case 0:
					return 'Download';
					break;
				case 1:
					return 'Audio\Video';
					break;
				case 2:
					return 'Shipped';
					break;
			}
		}

		static public function frontPage() {
			global $db;

			$result = $db->queryFill("SELECT product_id FROM products WHERE front_page = 1 AND published = 1 LIMIT 1");
			$result = array_shift($result);

			$product = new Products($result['product_id']);
			return $product;

		}

		static public function featured() {
			global $db;
			$featuredArray = array();

			$result_set = $db->queryFill("SELECT product_id FROM products WHERE featured = 1 AND published = 1");
			if ($result_set != false) {
				foreach ($result_set as $product) {
					$featuredArray[] = new Products($product['product_id']);
				}
			}

			return $featuredArray;
		}

		static public function productFromLink($link) {
			global $db;
			$product = null;

			$result = $db->queryFill("SELECT product_id FROM products WHERE directLink LIKE '%{$link}%' LIMIT 1");

			if ($result != false) {
				foreach ($result as $item) {
					$product = new Products($item['product_id']);
				}
			}

			return $product;
		}

		public function getCategory() {
			global $db;

			$result = $db->queryFill("SELECT category_id FROM productsForCategories WHERE product_id = {$this->product_id}");

			if ($result != false) {
				foreach ($result as $r) {
					return $r['category_id'];
				}
			}
		}

		private function addProductToCategory($cat_id) {
			global $db;
			global $error;

			$check = $db->queryFill("SELECT category_id FROM productsForCategories WHERE product_id = {$this->product_id}");

			if ($check != false) {
				$check = array_shift($check);
				if ($check['category_id'] != $cat_id) {
					$db->query("UPDATE productsForCategories SET category_id = {$cat_id} WHERE product_id = {$this->product_id}");
				}
			} else {
				$db->query("INSERT INTO productsForCategories (product_id, category_id) VALUES ({$this->product_id}, {$cat_id})");
			}

			if ($db->affectedRows() > 0) {
				return true;
			} else {
				$error->addMessage('The product could not be added to a category', 'Product3987');
				return false;
			}
		}

		private function createDownloadLink() {
			if ($this->type == 0) {
				return '/store/download.php?auth='.$this->product_id;
			} else if ($this->type == 1) {
				return '/store/watch_video.php?auth='.$this->product_id;
			}
		}


		public function setFeatured() {
			$this->featured = 1;
			$this->directLink = $this->sanitize($this->product_name, true);
			$this->save($this->product_id);
		}

		public function setFrontpage() {
			global $db;

			$db->query('UPDATE products SET front_page = 0');
			$this->front_page = 1;
			$this->directLink = $this->sanitize($this->product_name, true);
			$this->save($this->product_id);
		}

/* ========================================
	Purchase Methods
	==================================== */

		public function watchVideo() {

			$detect = new MobileDetect();

			if ($detect->isMobile()) {
				$height = 'style="height:70%; width:70% "';
			} else {
				$height = 'height="360" width="640" ';
			}
			$this->content =
					'<video id="video" '.$height.' preload="none" >
						<!-- Pseudo HTML5 -->
   						<source src="'.$this->download.'" />
					</video>';


		}


/* ========================================
	Display Methods
	==================================== */

		public function displayModule($product_id) {
			$this->fetchById($product_id);
			$this->setupMoney();
			$html = $this->productTable();
			return $html;
		}



		public function productTable() {
			global $display;
			global $users;

			$u = null;

			if (empty($display))  {
				$u = $users;
			} else {
				$u = $display->user;
			}


			$rowspan = ($this->countPrice() != 1) ? 'rowspan="'.$this->countPrice().'"' : '';

			$html = '<section class="product-table">
						<article>
							<h4><a href="'.$this->directLink.'">'.$this->product_name.'</a></h4>'.
							$this->content
						.'</article>
						<aside>';


	        if ($this->NM_price != '0') {
				$html .=	$this->priceSheets('non-members', $this->NM_price);
			}


			if ($this->M_price != '0') {
				if ($u->accessByGroup('members')) {
					$html .=	$this->priceSheets('members', $this->M_price);
				} else {
					$html .=	$this->priceSheets('members', $this->M_price, true);
				}

			}

			if ($this->I_price != '0') {
				$html .=	$this->priceSheets('institutional', $this->I_price);
			}

	        $html .= '</aside></section>';


			return $html;

		}

		private function priceSheets($class, $price, $disabled=false) {
			return '<div class="'.$class.' price-cell">
						<h3>'.$class.'</h3>
						<h5>'.$price.'</h5>'.
						$this->addToCartButton($price, $class, $disabled)
					.'</div>';
		}


		public function sidebarTable() {
			global $display;
			global $users;

			$u = null;

			if (empty($display))  {
				$u = $users;
			} else {
				$u = $display->user;
			}

			$this->setupMoney();

			$html = '<table class="product-sidebar"><tr class="productContent">';

			if ($this->NM_price != NULL) {
				$html .=	$this->priceSheets('non-members', $this->NM_price);
			}

			$html .='</tr><tr class="spacer"></tr><tr class="productContent">';

			if ($this->M_price != NULL) {
				if ($u->accessByGroup('members')) {
					$html .=	$this->priceSheets('members', $this->M_price);
				} else {
					$html .=	$this->priceSheets('members', $this->M_price, true);
				}

			}

			$html .='</tr><tr class="spacer"></tr><tr class="productContent">';

			if ($this->I_price != NULL) {
				$html .=	$this->priceSheets('institutional', $this->I_price);
			}

			$html .= '</tr></table>';

			return $html;

		}


		public function addToCartButton($price, $class, $disabled) {
			$price = substr($price, 1);
			if ($this->out_of_stock == 1) {
				return '<a class="add-to-cart disabled ">Out of Stock</a>';
			}

			if ($disabled) {
				return '<a class="add-to-cart disabled">Please Log In</a>';
			} else {
				return '<a class="add-to-cart" href="#" data-price="'.$price.'" data-id="'.$this->product_id.'">Add to Cart</a>';
			}
		}


		private function countPrice() {
			$priceArray = array($this->NM_price, $this->M_price, $this->I_price);
			$count = array_count_values($priceArray);
			if (isset($count['0'])) {
				return  3 - $count['0'];
			} else {
				return 3;
			}

		}


/* ========================================
	Admin Methods
	==================================== */

	//CRU
	public function createFromForm($post) {
		global $error;

		$this->fillFromForm($post);
		$this->directLink = $this->sanitize($post['product_name'], true);

		$p_id = $this->save($this->product_id);


		//Add to Categories
		$saveP = new Products($p_id);
		$saveP->addProductToCategory($this->category_id);

		if (!empty($p_id)) {
			return $p_id;
		} else {
			$error->addError('The product information did not save.', 'Products1284');
		}
	}



	//Delete
	public function deleteFromForm() {
		global $error;

		if ($this->delete($this->product_id)) {
			return true;
		} else {
			$error->addError('The product information did not delete.', 'Product1564');
		}
	}




/* ========================================
	Redefine Methods
	==================================== */


	public function displayFeatured() {
		global $db;

		$html = '<a title="featured" id="'.$this->product_id.'" class="ninjaSymbol ninjaSymbolStar productStar ';

		if ($this->featured == 1) {
			$html .= 'active';
		}

		$html .= '"></a>';

		return $html;
	}


	public function displayFrontpage() {
		global $db;

		$html = '<a title="frontpage" id="'.$this->product_id.'" class="ninjaSymbol ninjaSymbolStar productStar ';

		if ($this->front_page == 1) {
			$html .= 'active';
		}

		$html .= '"></a>';

		return $html;
	}



}// /Class
?>
