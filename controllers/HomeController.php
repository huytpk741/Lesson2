<?php

    class HomeController extends Controller
    {
        public function index()
        {
        	require_once VIEW . "layout/header.php";
            require_once VIEW . 'home.php';
            require_once VIEW . "layout/footer.php";
        }
    }

?>