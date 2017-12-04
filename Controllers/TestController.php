<?php
    namespace Controllers;

    class TestController
    {
        protected $container;

        public function __construct(){

        }

        public function Test($request, $response, $args) {
            return "test";
        }

        public function display($request, $response, $args) {
            echo 'blah';
        }

    }
?>