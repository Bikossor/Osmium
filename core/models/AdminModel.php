<?php
    class AdminModel extends Model {
        public function __construct() {
            parent::__construct();
        }

        public function xhrGetArticles() {
            $sth = $this->db->query('SELECT * FROM articles;');
            $data = $sth->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: applicaton/json');
            header('Cache-Control: public, max-age=10');
            echo json_encode($data);
        }

        public function xhrInsertArticle() {
            $sth = $this->db->prepare('INSERT INTO articles (Title) VALUES (:title);');
            $sth->execute([
                'title' => filter_input(INPUT_POST, 'Text', FILTER_SANITIZE_STRING)
            ]);
        }
    }
?>