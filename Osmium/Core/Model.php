<?php

namespace Osmium\Core {
    abstract class Model
    {
        public function __construct()
        {
            $this->db = new Database();
        }
    }
}
