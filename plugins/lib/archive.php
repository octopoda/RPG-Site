<?php

    class Archive extends databaseObject{

        public $table = "archive";
        public $idfield = "archive_id";

        public $archive_id;
		public $archive_title;
		public $datePublished;
		public $published;
		public $archive_link;
		public $volume;
		public $issue;

		//Helpers
		public $articleList = array();



		public function __construct($a_id="") {
           if (empty($a_id)) $a_id = $this->archive_id;

			if (!empty($a_id)) {
         		$result = $this->fetchById($a_id);
			}
        }
/* ========================================
	Build/Helper Methods
	==================================== */

		public function setDate() {
			$year = date("Y", strtotime($this->datePublished));
			$month = date("m", strtotime($this->datePublished));
			$season;

			switch ($month) {
				case '01':
					$season = 'Winter';
					break;
				case '03':
					$season = "Spring";
					break;
				case '06':
					$season = "Summer";
					break;
				case '09':
					$season = "Fall";
					break;
			}

			$this->datePublished = date("F - Y", strtotime($this->datePublished));

			$fullDate = $season . ' - ' . $year;
			return $fullDate;
		}


		public function yearSelect() {
			$year = date('Y');

			$past = $year - 20;
			$future = $year + 20;

			$html = '<select name="year" id="year">';

			for($i=$past; $i<=$future; $i++) {
				$html .= '<option value="'.$i.'"';
				if ($i == $year) {
					$html .= 'selected';
				}
				$html .= ' >'.$i.'</option>';
			}

			$html .= "</select>";

			return $html;
		}



		public function returnYearList() {
		$years = array();
		$pastYear = 1;

		$result_set = $this->getAllDates();

		if ($result_set != false) {
			foreach ($result_set as $row) {
				$time = date('Y', strtotime($row['datePublished']));

				if ($time != $pastYear) {
					$years[] = $time;
				}

				$pastYear = date('Y', strtotime($row['datePublished']));
			}
		}

		return $years;
	}

	public function getArchivesForYear($year) {
		$result_set = $this->getAllDates();
		$months = array();
		if ($result_set != false) {
			foreach ($result_set as $row) {
				$time = date('Y', strtotime($row['datePublished']));
				if ($time == $year) {
					$month = date('m', strtotime($row['datePublished']));

					switch ($month) {
						case '01':
							$season = 'Winter';
							break;
						case '03':
							$season = "Spring";
							break;
						case '06':
							$season = "Summer";
							break;
						case '09':
							$season = "Fall";
							break;
					}
					$months[$row['archive_id']] = $season;
				}
			}
		}

		return $months;
	}

	private function  getAllDates() {
		global $db;

		$result_set = $db->queryFill("SELECT * FROM archive WHERE published = 1 ORDER BY datePublished DESC");
		return $result_set;
	}



/* ========================================
	Article Methods
	==================================== */

		public function buildArticleList($limit="") {
			global $db;

			if (!empty($limit)) {
				$sql = "SELECT article_id FROM articlesForArchive WHERE archive_id = {$this->archive_id} ".$limit;
			} else {
				$sql = "SELECT article_id FROM articlesForArchive WHERE archive_id = {$this->archive_id}";
			}

			$result_set = $db->queryFill($sql);

			if ($result_set != false) {
				foreach ($result_set as $row) {
					$this->articleList[] = new Article($row['article_id']);
				}
			}
		}


		public function numberOfArticles() {
			global $db;

			$result_set = $db->queryFill("SELECT * FROM articlesForArchive AA JOIN article A ON AA.article_id = A.article_id WHERE AA.archive_id = {$this->archive_id} AND A.published = 1");
			return count($result_set);
		}

/* ========================================
	Display Methods
	==================================== */

	static public function searchContent($searchTerm, $limit = null) {
		global $db;

		if (empty($limit)) {
			$sql = "SELECT article_id FROM content WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%'";
		} else {
			$sql = "SELECT article_id FROM content WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%'" . $limit;
		}

		$result_set = $db->queryFill($sql);
		return $result_set;
	}

	static public function lastestArchive() {
		global $db;

		$result_set = $db->queryFill("SELECT archive_id FROM archive WHERE published = 1 ORDER BY datePublished DESC LIMIT 1");
		if ($result_set != false) {
			$result = array_shift($result_set);
			return $result['archive_id'];
		}

	}

/* ========================================
	Admin Methods
	==================================== */

	//CRU
	public function createFromForm($post) {
		global $error;

		$this->fillFromForm($post);

		$month = $_POST['month'];
		$year = $_POST['year'];

		$this->datePublished = $year.'-'.$month.'-01 12:00:00';

		$archive_id = $this->save($this->archive_id);

		if (!empty($archive_id)) {
			return $archive_id;
		} else {
			$error->addError('The information did not save.', 'Archive1284');
		}
	}



	//Delete
	public function deleteFromForm() {
		global $error;
			$this->buildArticleList();


			foreach ($this->articleList as $article) {
				$article->deleteFromForm($article->article_id);
			}


			if ($this->delete($this->archive_id)) {
				return true;
			} else {
				$error->addError('The information did not delete.', 'Archive1564');
			}
	}




/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
