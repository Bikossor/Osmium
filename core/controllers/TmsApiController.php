<?php
	class TmsApiController extends Controller {
		public function __construct() {
            parent::__construct();
		}

        public function index() {
            //$this->view->data = $this->model->run();
            $this->view->render('tmsapi/index');
        }

        public function run() {
            $this->model->run();
        }

        public function Test() {
            $this->model->Test();
        }
	}
?>