<?php
	class RestApiController extends Controller {
		public function __construct() {
            parent::__construct();
		}

        public function index() {
            
        }

        public function Test() {
            $this->model->Test();
        }
	}
?>