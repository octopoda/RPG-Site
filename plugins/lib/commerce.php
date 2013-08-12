<?php
	
	class Commerce extends databaseObject {
        public $table = "commerce";
        public $idfield = "site_id";

		public $site_id;
		public $sales_tax;
		public $shipping_cost;
		public $auth_id;
		public $trans_id;
		public $type; 
		public $pp_auth;
		public $pp_secret;


		public function __construct() {
			$this->fetchById(1);
		}
/* ========================================
	Build/Helper Methods
	==================================== */


/* ========================================
	Display Methods
	==================================== */


/* ========================================
	Admin Methods
	==================================== */
		public function createFromForm($post) {
			$this->fillFromForm($post);
			$id = $this->save(1);

			return $id;
		}




/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
