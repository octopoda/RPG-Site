<?php
   	



    class Ads extends databaseObject{

        public $table = "ads";
        public $idfield = "ad_id";

        public $ad_id;
		public $title;
		public $published;
		public $placement;
		public $user_id;
		public $image;
		public $link;


		public $access = 0;
		public $printImage;
		public $humanPlacement;

        public function __construct($a_id="") {
           if (empty($a_id)) $a_id = $this->ad_id;

			if (!empty($a_id)) {
         		$result = $this->fetchById($a_id);
         		$this->printImage = $this->printImage();
         		$this->setPlacement();
			}
        }
/* ========================================
	Build/Helper Methods
	==================================== */

	public function setPlacement() {
		switch ($this->placement) {
			case 0:
				$this->humanPlacement = 'Sidebar 1';
				break;
			case 1:
				$this->humanPlacement = 'Sidebar 2';
				break;
			case 2:
				$this->humanPlacement = 'Navigation Bar';
				break;
		}
	}


	public function listAds() {
		global $db;

		$result_set = $db->queryFill("SELECT ad_id FROM ads ");

		if ($result_set != false) {
			foreach ($result_set as $row) {
				$this->adList[] = new Ads($row['ad_id']);
			}
		}
	}

	private function printImage() {
		return '<a href="'.$this->link.'" target="_blank"><img src="'.$this->image.'" alt="'.$this->title.'"></a>';
	}


/* ========================================
	Display Methods
	==================================== */

	static function adIdFromTitle($title) {
		global $db;


		$result_set = $db->queryFill("SELECT ad_id FROM ads WHERE title LIKE '{$title}'");

		if ($result_set != false) {
			foreach ($result_set as $row) {
				return $row['ad_id'];
			}
		}
	}

	static public function adsFromPlacement($placement) {
		global $db;
		$ads = array();



		$result = $db->queryFill("SELECT ad_id FROM ads WHERE placement = '{$placement}' AND published = 1");

		if ($result != false) {
			foreach ($result as $r) {
				$ads[] = new Ads($r['ad_id']);
			}

			return $ads;
		} else {


		}
	}

/* ========================================
	Admin Methods
	==================================== */

	//CRU
	public function createFromForm($post) {
		global $error;

		$this->fillFromForm($post);

		$ad_id = $this->save($this->ad_id);

		if (isset($ad_id)) {
			return $ad_id;
		} else {
			$error->addError('The information did not save.', 'Ads1284');
		}
	}



	//Delete
	public function deleteFromForm() {
		global $error;

		if ($this->delete($this->ad_id)) {
			return true;
		} else {
			$error->addError('the information did not save.' ,'Ads1564');
		}
	}


/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
