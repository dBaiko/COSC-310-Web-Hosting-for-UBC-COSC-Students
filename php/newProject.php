<?php

require 'newProjectClass.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(isset($_SERVER["REQUEST_METHOD"])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_SESSION["user"];
        
        $newProjectCreator = new newProject();
        
        $newProjectCreator->setUserName($username);
        
        if(isset($_POST["title"])){
            $newProjectCreator->setTitle($_POST["title"]);
        }
        
        if(isset($_POST["description"])){
            $newProjectCreator->setDesc($_POST["description"]);
        }
        
        if(isset($_POST["link"])){
            $newProjectCreator->setLink($_POST["link"]);
        }
        
        if(isset($_POST["projType"])){
            $newProjectCreator->setType($_POST["projType"]);
        }
        
        if(isset($_POST["contributor"])){
            $newProjectCreator->buildContribArray($_POST["contributor"]);
        }
        
        if($_FILES['pics'] != null){
            $newProjectCreator->buildFileArrays($_FILES['pics']);
        }
        
        if(isset($_FILES['pdfs'])){
            $newProjectCreator->buildFileArrays($_FILES['pdfs']);
        }
        
        $logoFile = $_FILES['logo']['tmp_name'];
        if($logoFile != null){
            $newProjectCreator->logo = file_get_contents($logoFile);
        }
        else{
            $newProjectCreator->logo = file_get_contents("../Images/default.png");
        }
        
        if($newProjectCreator->createNewProject($newProjectCreator->userName, $newProjectCreator->title, $newProjectCreator->desc, $newProjectCreator->type, $newProjectCreator->link, $newProjectCreator->contribArray, $newProjectCreator->fileNames, $newProjectCreator->fileTypes, $newProjectCreator->files, $newProjectCreator->logo, null,$_SESSION['user'])){
            $newProjectCreator = null;    
            ?>
            <meta http-equiv="refresh" content="0; URL='../Browse.php'" />
            <?php
        }
        else{
           ?>
           <meta http-equiv="refresh" content="0; URL='../CreateAProject.php'" />
           <?php 
        }
    }
}