<?php
    class Controller {
		protected $header;
        protected $footer;
        protected $title;
        protected $user;
		
		public function __construct() {
			$this->header = VIEW . "layout/header.php";
            $this->footer = VIEW . "layout/footer.php";

            $this->title = "Home";
		}
		
		protected function get_header() {
            return $this->header;
        }

        protected function get_footer() {
            return $this->footer;
        }

        protected function load_model($model_name) {
			$path = "models/" . $model_name . ".php";
			if (file_exists($path)) {
				require_once($path);
				return new $model_name();
			} else {
				return null;
			}
		}

    }
?>