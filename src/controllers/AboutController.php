<?php
	class AboutController extends Controller {
		public function __construct() {
            parent::__construct();
		}

        public function index() {
            $this->view->articles = $this->model->getArticles();
            
            $this->view->render('about/index');
        }
	}
?>