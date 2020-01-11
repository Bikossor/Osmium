<?php

namespace Osmium\Model {

    use Osmium\Core\Model;

    class AboutModel extends Model
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
