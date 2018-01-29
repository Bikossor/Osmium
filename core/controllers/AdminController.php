<?php
	class AdminController extends Controller {
		public function __construct() {
            parent::__construct();
		}

        public function index() {
            $this->view->render('admin/index');
        }

        public function xhrGetArticles() {
            $this->model->xhrGetArticles();
            exit();
        }

        public function xhrInsertArticle() {
            $this->model->xhrInsertArticle();
            exit();
        }
	}
?>