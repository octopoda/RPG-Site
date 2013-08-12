<?php


    class ProductCategories extends databaseObject{

        public $table = "productCategories";
        public $idfield = "category_id";

        public $category_id;
		public $category_name;
		public $published;
		public $directLink;
		public $access;


		//Helpers
		public $productList = array();
		public $title;
		public $content = " ";


		public function __construct($c_id="") {
           if (empty($c_id)) $c_id = $this->category_id;

			if (!empty($c_id)) {
         		$result = $this->fetchById($c_id);
         		$this->title = $this->category_name;
			}
    }
/* ========================================
	Build/Helper Methods
	==================================== */

		public function productsForCategories() {
			global $db;


			$results = $db->queryFill("SELECT product_id FROM productsForCategories WHERE category_id = {$this->category_id}");
			if ($results != false) {
				foreach ($results as $r) {
					$this->productList[] = new Products($r['product_id']);
				}
			}
		}

		static public function categoryFromTitle($title) {
			global $db;

			$result = $db->queryFill("SELECT category_id FROM productCategories WHERE category_name = '{$title}' LIMIT 1");
			if ($result != false) {
				foreach ($result as $r) {
					return new ProductCategories($r['category_id']);
				}
			}
		}


		static public function categoryFromLink($link) {
			global $db;

			$result = $db->queryFill("SELECT category_id FROM productCategories WHERE directLink = '{$link}' LIMIT 1");
			if ($result != false) {
				foreach ($result as $r) {
					return new ProductCategories($r['category_id']);
				}
			}
		}

		public function displayModule($category_name) {
			$this->fetchByKey('category_name', $category_name);
			$this->productsForCategories();

			if ($this->productList == false) {
				return false;
			}


			$html = '<div><h2>'.$this->category_name.'</h2>';
			foreach ($this->productList as $product) {
				$product->setupMoney();
				$html  .= $product->productTable();
			}
			$html .= '</div>';

		 	return $html;
		}



/* ========================================
	Display Methods
	==================================== */
		static public function listCategories() {
			global $db;
			$list = array();

			$result_set = $db->queryFill("SELECT * FROM productCategories WHERE published = 1 ORDER by category_name ASC");
			if ($result_set != false) {
				foreach ($result_set as $category){
					$list[$category['category_id']] = $category['category_name'];
				}
			}

			return $list;
		}

		public function createContent($access) {
			$this->productsForCategories();

			$html = '<div class="category-product-listing">';
			foreach ($this->productList as $product) {
				if ($product->published == 0 || $product->access > $access) continue;
				$product->setupMoney();
				$html  .= $product->productTable() . '<br /><br />';
			}
			$html .= '</div>';

			return $html;
		}






/* ========================================
	Admin Methods
	==================================== */

	//CRU
	public function createFromForm($post) {
		global $error;

		$this->fillFromForm($post);
		$this->directLink = $this->sanitize($post['category_name']);


		$category_id = $this->save($this->category_id);

		if (!empty($category_id)) {
			return $category_id;
		} else {
			$error->addError('The information did not save.', 'ProductCategory1284');
		}
	}


	//Delete
	public function deleteFromForm() {
		global $error;
		global $db;

			$db->query("DELETE FROM productsForCategories WHERE category_id = {$this->category_id}");

			if ($this->delete($this->category_id)) {

				return true;
			} else {
				$error->addError('The information did not delete.', 'ProductCategory1564');
			}
	}



/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
