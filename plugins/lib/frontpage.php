<?php

    class FrontPage extends databaseObject{

        public $table = "frontPage";
        public $idfield = "front_id";

        public $front_id;
        public $published;
        public $image_url;
        public $title;
        public $content;
        public $link;


        public function __construct($fp_id="") {
           if (empty($fp_id)) $fp_id = $this->front_id;

			if (!empty($fp_id)) {
         		$result = $this->fetchById($fp_id);
         	}
        }
/* ========================================
	Build/Helper Methods
	==================================== */

	static public function listFrontPage() {
		global $db;
		$items = array();

		$result = $db->queryFill("SELECT front_id FROM frontPage WHERE published = 1 ORDER BY position ASC");

		if ($result != false) {
			foreach ($result as $r) {
				$items[] = new FrontPage($r['front_id']);
			}
		}

		return $items;
	}




/* ========================================
	Display Methods
	==================================== */

    public function printImage() {
        return '<img src="'.$this->image_url.'" alt="'.$this->title.'">';
    }

/* ========================================
	Admin Methods
	==================================== */

	//CRU
	public function createFromForm($post) {
		global $error;

		$this->fillFromForm($post);

		$fp_id = $this->save($this->front_id);

		if (isset($fp_id)) {
			return $fp_id;
		} else {
			$error->addError('The information did not save.', 'FrontPage1284');
		}
	}



	//Delete
	public function deleteFromForm() {
		global $error;

		if ($this->delete($this->front_id)) {
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
