<?php

namespace Osmium\Model {

    use Osmium\Core\Model;

    class RestApiModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function Test()
        {
            // $sth = $this->db->query('SELECT * FROM articles;');
            $data = [
                [
                    "Name" => "Felix Blume",
                    "StageName" => "Kollegah",
                    "Age" => 34
                ],
                [
                    "Name" => "Donald Glover",
                    "StageName" => "Childish Gambino",
                    "Age" => 35
                ],
                [
                    "Name" => "Michael Schindler",
                    "StageName" => "Shindy",
                    "Age" => 30
                ]
            ];

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

        public function xhrInsertArticle()
        {
            $sth = $this->db->prepare('INSERT INTO articles (Title) VALUES (:title);');
            $sth->execute([
                'title' => filter_input(INPUT_POST, 'Text', FILTER_SANITIZE_STRING)
            ]);
        }
    }
}
