<?php


    class subCats extends databaseObject{

        public $table = "subCats";
        public $idfield = "sub_id";

        public $sub_id;
		public $sub_name;
		public $published;

		//Helpers
		public $articleList = array();


		public function __construct($c_id="") {
           if (empty($c_id)) $c_id = $this->sub_id;

			if (!empty($c_id)) {
         		$result = $this->fetchById($c_id);
			}
        }
/* ========================================
	Build/Helper Methods
	==================================== */

		static public function topCategory() {
			global $db;

			$result = $db->queryFill("SELECT sub_id FROM subCats ORDER BY sub_name ASC");
			$result = array_shift($result);

			return $result['sub_id'];
		}

		public function numberOfArticles() {
			global $db;

			$result = $db->queryFill("SELECT * FROM categoriesForArticle CA JOIN article A ON CA.article_id = A.article_id WHERE CA.category_id = {$this->sub_id} AND A.published = 1 ");
			return count($result);
		}

		public function buildArticleList($limit="") {
			global $db;

			if (!empty($limit)) {
				$sql = "SELECT article_id FROM categoriesForArticle WHERE category_id = {$this->sub_id} ".$limit;
			} else {
				$sql = "SELECT article_id FROM categoriesForArticle WHERE category_id = {$this->sub_id}";
			}

			$result_set = $db->queryFill($sql);

			if ($result_set != false) {
				foreach ($result_set as $row) {
					$this->articleList[] = new Article($row['article_id']);
				}
			}
		}


		public function buildSubCatForm ($cat_id="") {
			$checked = array();

			if (!empty($cat_id)) {
				$cat = new Categories($cat_id);
				$checked = $cat->subCatsForCategory($cat_id);
			}

			$list = $this->listSubCats();

			$html = '<ul class="subCatList">';

			foreach ($list as $key=>$value) {
				$html .= "<li>";
				$html .= '<input type="checkbox" name="subCats[]" id="subCats" value="' .$key.'"';
				if (in_array($key, $checked)) {
					$html .= ' checked ';
				}
				$html .= '/>';
				$html .= '<label for="subCats">'.$value.'</label>';
				$html .= "</li>";
			}

			$html .= "</ul>";

			return $html;

		}




/* ========================================
	Display Methods
	==================================== */
		public function titleSearch($string) {
			global $db;

			$result_set = $db->queryFill("SELECT sub_name FROM subCats WHERE sub_name LIKE '%".$string."%'");

			return $result_set;
		}

		public function listsubCats() {
			global $db;
			$list = array();

			$result_set = $db->queryFill("SELECT * FROM subCats WHERE published = 1 ORDER by sub_name ASC");
			if ($result_set != false) {
				foreach ($result_set as $category){
					$list[$category['sub_id']] = $category['sub_name'];
				}
			}

			return $list;
		}



/* ========================================
	Admin Methods
	==================================== */

	//CRU
	public function createSubCatFromForm($post) {
		global $error;

		$this->fillFromForm($post);


		$sub_id = $this->save($this->sub_id);

		if (!empty($sub_id)) {
			return $sub_id;
		} else {
			$error->addError('The information did not save.', 'Sub1284');
		}
	}



	//Delete
	public function deleteFromForm() {
		global $error;

			if ($this->delete($this->sub_id)) {
				return true;
			} else {
				$error->addError('The information did not delete.', 'Sub1564');
			}
	}


	public function fetchIdFromName($name) {
		global $db;
		$result_set = $db->queryFill("SELECT sub_id FROM subCats WHERE sub_name = '{$name}' LIMIT 1");
		$result_set = array_shift($result_set);
		return $result_set['sub_id'];
	}

/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
