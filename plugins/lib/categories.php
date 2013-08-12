<?php


    class Categories extends databaseObject{

        public $table = "categories";
        public $idfield = "category_id";

        public $category_id;
		public $category_name;
		public $published;

		//Helpers
		public $articleList = array();


		public function __construct($c_id="") {
           if (empty($c_id)) $c_id = $this->category_id;

			if (!empty($c_id)) {
         		$result = $this->fetchById($c_id);
			}
        }
/* ========================================
	Build/Helper Methods
	==================================== */

		static public function topCategory() {
			global $db;

			$result = $db->queryFill("SELECT category_id FROM categories ORDER BY category_name ASC");
			$result = array_shift($result);

			return $result['category_id'];
		}

		public function numberOfArticles() {
			global $db;

			$result = $db->queryFill("SELECT C.category_id FROM subCatsForCat S JOIN categoriesForArticle C ON S.sub_id = C.category_id WHERE S.category_id = {$this->category_id}");
			return count($result);
		}

		public function buildArticleList($limit="") {
			global $db;

			if (!empty($limit)) {
				$sql = "SELECT C.article_id FROM subCatsForCat S JOIN categoriesForArticle C ON S.sub_id = C.category_id WHERE S.category_id = {$this->category_id} ".$limit;
			} else {
				$sql = "SELECT C.article_id FROM subCatsForCat S JOIN categoriesForArticle C ON S.sub_id = C.category_id WHERE S.category_id = {$this->category_id}";
			}

			$result_set = $db->queryFill($sql);

			if ($result_set != false) {
				foreach ($result_set as $row) {
					$this->articleList[] = new Article($row['article_id']);
				}
			}
		}


		public function subCatsForCategory($cat_id = "") {
			global $db;
			$subIds = array();

			if (empty($cat_id)) $cat_id = $this->category_id;

			$result_set = $db->queryFill("SELECT sub_id FROM subCatsForCat WHERE category_id = {$cat_id}");

			if ($result_set != false) {
				foreach ($result_set as $result) {
					$subIds[] = $result['sub_id'];
				}
			}

			return $subIds;
		}











/* ========================================
	Display Methods
	==================================== */
		public function titleSearch($string) {
			global $db;

			$result_set = $db->queryFill("SELECT category_name FROM categories WHERE category_name LIKE '%".$string."%'");

			return $result_set;
		}

		public function listCategories() {
			global $db;
			$list = array();

			$result_set = $db->queryFill("SELECT * FROM categories WHERE published = 1 ORDER by category_name ASC");
			if ($result_set != false) {
				foreach ($result_set as $category){
					$list[$category['category_id']] = $category['category_name'];
				}
			}

			return $list;
		}



/* ========================================
	Admin Methods
	==================================== */

	//CRU
	public function createCategoryFromForm($post) {
		global $error;

		$this->fillFromForm($post);


		$category_id = $this->save($this->category_id);

		if (!empty($category_id)) {
			return $category_id;
		} else {
			$error->addError('The information did not save.', 'Category1284');
		}
	}


	//Delete
	public function deleteFromForm() {
		global $error;
		global $db;

			$db->query("DELETE FROM subCatsForCat WHERE category_id = {$this->category_id}");

			if ($this->delete($this->category_id)) {

				return true;
			} else {
				$error->addError('The information did not delete.', 'Category1564');
			}
	}

	//Enter SubNav
	public function createSubTopic($array, $cat_id) {
		global $error;
		global $db;

		$db->query("DELETE FROM subCatsForCat WHERE category_id = {$cat_id}");

		foreach ($array as $sub) {
			$db->query("INSERT INTO subCatsForCat (category_id, sub_id) VALUES ('{$cat_id}','{$sub}')");
		}
	}

	//Get name from Id;
	public function fetchIdFromName($name) {
		global $db;
		$result_set = $db->queryFill("SELECT category_id FROM categories WHERE category_name = '{$name}' LIMIT 1");
		$result_set = array_shift($result_set);
		return $result_set['category_id'];
	}

/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
