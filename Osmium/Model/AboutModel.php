<?php

namespace Osmium\Model {
    class AboutModel extends \Osmium\Core\Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function getArticles(): array
        {
            $sth = $this->db->query('SELECT * FROM articles');
            $sth->execute();
            return $sth->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
}
