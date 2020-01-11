<?php

namespace Osmium\Model {
    class LoginModel extends \Osmium\Core\Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function run()
        {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $sth = $this->db->prepare('SELECT uid, name, password FROM users WHERE name=:name');
            $sth->execute(['name' => $name]);

            $data = $sth->fetch(\PDO::FETCH_ASSOC);

            $success = password_verify($password, $data['password']);

            if ($success) {
                echo "Logged In!";
                // Session::start();
                $_SESSION['UID'] = $data['uid'];
            } else {
                throw new \Exception("Username or password wrong!");
            }
        }
    }
}
