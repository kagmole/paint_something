<?php
session_start();

require("pagemanager.php");

$pageManager = PageManager::getInstance();

if (isset($_GET["page"])) {
    $pageManager->showPage($_GET["page"]);
} else {
    $pageManager->showPage();
}