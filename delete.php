<?php
require_once 'globals.php';
require_once 'classes/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $delete = "DELETE FROM postcards WHERE ID = :id";
    }

    try { 
        $db = database::getInstance();
        $stmt = $db->prepare($delete);
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
      
        header('Location: show.php');
    } catch (PDOException $e) {
        header('Location: show.php');
    }
