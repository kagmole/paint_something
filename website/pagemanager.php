<?php
class PageManager {
    
    private static $instance = null;
    
    private $connected;
    
    private function __construct() {
        $this->connected = isset($_SESSION) ? true : false;
    }
    
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new PageManager();
        }
        return self::$instance;
    }
    
    public function showPage($alias = null) {
        switch ($alias) {
        case null:
            $this->showPageBase();
            break;
        case "join":
            $this->showPageJoin();
            break;
        case "login":
            $this->showPageLogin();
            break;
        default:
            // TODO
            echo "ERROR 404";
            break;
        }
    }
    
    private function showPageBase() {
        require("base.php");
    }
    
    private function showPageJoin() {
        require("join.php");
    }
    
    private function showPageLogin() {
        require("login.php");
    }
}