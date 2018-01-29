<?php
    class Session
    {
        public function __construct() {

        }

        public static function start() {
            if(session_id() == "") {
                session_start();
            }
        }

        public static function stop() {
            session_unset();
            session_destroy();
        }
    }

?>
