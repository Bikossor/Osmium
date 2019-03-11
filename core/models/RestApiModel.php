<?php
    class RestApiModel extends Model {
        public function __construct() {
            parent::__construct();
        }

        public function Test() {
            $sth = $this->db->query('SELECT * FROM articles;');
            $data = $sth->fetchAll(PDO::FETCH_ASSOC);

            header('Access-Control-Allow-Origin: *');
            header('Cache-Control: public, max-age=10');
            header('Content-Type: application/json; charset=utf-8');
            header('Content-Encoding: gzip');
            header('Transfer-Encoding: gzip');     
            
            ob_start('ob_gzhandler');

            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        }
        
        public function xhrInsertArticle() {
            $sth = $this->db->prepare('INSERT INTO articles (Title) VALUES (:title);');
            $sth->execute([
                'title' => filter_input(INPUT_POST, 'Text', FILTER_SANITIZE_STRING)
            ]);
        }
    }
?>