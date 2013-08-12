<?php


    class Article extends databaseObject{

        public $table = "article";
        public $idfield = "article_id";

		public $article_id;
        public $article_title;
		public $article_link;
		public $description;
		public $published;
		public $author;

		//Helpers
		public $categoryList = array();

		public function __construct($a_id="") {
           if (empty($a_id)) $a_id = $this->article_id;

			if (!empty($a_id)) {
         		$result = $this->fetchById($a_id);
				$this->buildCategories($a_id);
			}
        }
/* ========================================
	Build/Helper Methods
	==================================== */
		private function buildCategories() {
			global $db;

			$set = $db->queryFill("SELECT category_id FROM categoriesForArticle WHERE article_id = {$this->article_id}");

			if ($set != false) {
				foreach ($set as $row) {
					$this->categoryList[] = new SubCats($row['category_id']);
				}
			}
		}

		public function listCategories() {
			$string ='';

			foreach ($this->categoryList as $category) {
				$string .= ' '.$category->sub_name.', ';
			}

			return $string;
		}


/* ========================================
	Display Methods
	==================================== */

	public function searchArticles($searchTerm, $limit = null) {
		global $db;
		$result_set = array();


		$query = "SELECT * FROM articleSearch WHERE";
		$array = explode(" ", $searchTerm);

		foreach ($array as $key => $keyword){
			$query .= " article_title LIKE '%$keyword%' or description LIKE '%$keyword%' or sub_name LIKE '%$keyword%'";
			if ($key != (sizeof($array) - 1))   //skip adding the last 'AND' to
					$query .= " OR ";                // prevent a bad query
		}


		if (!empty($limit)){
			$query = $query . " " . $limit;
		}


		$result_set = $db->queryFill($query);
		return $result_set;
	}

/* ========================================
	Admin Methods
	==================================== */

	//CRU
	public function createFromForm($post) {
		global $error;

		$id_array = $this->parseCategories($post['categories']);
		$this->fillFromForm($post);
		$article_id = $this->save($this->article_id);

		if (!empty($article_id)) {
			$this->addArticleToArchiveList($article_id, $post['archive_id']);
			$this->addCategoryToArticle($article_id, $id_array);
			return;
			//return $article_id;
		} else {
			$error->addError('The information did not save.', 'Archive1284');
		}
	}



	//Delete
	public function deleteFromForm() {
		global $error;

			$this->removeArticleFromArchiveList($this->article_id);
			$this->removeArticleFromCategoryList($this->article_id);

			if ($this->delete($this->article_id)) {
				return true;
			} else {
				$error->addError('The information did not delete.', 'Archive1564');
			}
	}

	//Add Article to Archive List
	private function addArticleToArchiveList($a_id="", $archive_id) {
		global $db;
		global $error;
		if (empty($a_id)) $a_id = $this->article_id;

		$set = $db->queryFill("SELECT article_id FROM articlesForArchive WHERE article_id = {$a_id}");

		if ($set == false) {
			$db->query("INSERT INTO articlesForArchive (archive_id, article_id) VALUES ('{$archive_id}','{$a_id}')");
		} else {
			$db->query("UPDATE articlesForArchive SET archive_id = {$archive_id} WHERE article_id = {$a_id}");
		}
	}

	//Remove Article from Archive List
	private function removeArticleFromArchiveList($a_id="") {
		global $db;
		global $error;

		if (empty($a_id)) $a_id = $this->article_id;
		$db->query("DELETE FROM articlesForArchive WHERE article_id = {$a_id}");



	}

	private function parseCategories($string) {
		$categories = explode(",", $string);

		$id = array();
		foreach ($categories as $sub_name) {
			$sub_name = trim($sub_name);
			if ($sub_name != NULL) {
				$category = new subCats();
				$id[] = $category->fetchIdFromName(trim($sub_name));
			}
		}
		return $id;
	}

	private function addCategoryToArticle($a_id="", $id_array) {
		global $db;

		if (empty($a_id)) $a_id = $this->article_id;


		$set = $db->queryFill("SELECT * FROM categoriesForArticle WHERE article_id = {$a_id}");

		if ($set != false) {
			$db->query("DELETE FROM categoriesForArticle WHERE article_id = {$a_id}");
		}

		foreach ($id_array as $c_id) {
			$db->query("INSERT INTO categoriesForArticle (article_id, category_id) VALUES ('{$a_id}','{$c_id}')");
		}
	}

	private function removeArticleFromCategoryList($a_id="") {
		global $db;

		if (empty($a_id)) $a_id = $this->article_id;
		$db->query("DELETE FROM categoriesForArticle WHERE article_id = {$a_id}");

	}


	private function removeCategoryFromArticle($a_id="", $c_id) {
		global $db;

		if (empty($a_id)) $a_id = $this->article_id;
		$db->query("DELETE FROM categoriesForArticle WHERE article_id = {$a_id} AND category_id = {$c_id}");
	}




/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
