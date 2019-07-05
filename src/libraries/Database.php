<?php
    class Database extends PDO {
        public function __construct() {
            parent::__construct(sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME), DB_USER, DB_PASS);
        }
    }
?>
