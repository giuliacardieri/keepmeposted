<?php
require_once 'classes/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $fields = '';
    $values = '';
    $pdo_parameters = array();
    $favorite = false;
    
    foreach ($_POST as $key => $value) {
        $pdo_parameters[':' . filter_var($key)] =  filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);      
        $values .= ':' . filter_var($key) . ',';
        $fields .= filter_var($key) . ',';
        if ($key == 'favorite'){
          $favorite = true; 
        }
    }
  
    if (!$favorite){
      $pdo_parameters[':favorite'] =  0;
      $values .= ':favorite, ';
      $fields .= 'favorite, ';
    }
  
    // the photo will be added as a blob
    $name  = $_FILES['photo']['tmp_name'];
    $blob = fopen($name,'rb');
    $values .= ':photo';
    $fields .= 'photo';
  
    //$fields = substr($fields, 0, strlen($fields) - 1);
    //$values = substr($values, 0, strlen($values) - 1);
    
    $insert = "INSERT INTO postcards ($fields) VALUES ($values)";
    try {
        $db = database::getInstance();
        $stmt = $db->prepare($insert);
        $stmt->bindParam(':description',$pdo_parameters[':description']);
        $stmt->bindParam(':sender',$pdo_parameters[':sender']);
        $stmt->bindParam(':category',$pdo_parameters[':category']);
        $stmt->bindParam(':country',$pdo_parameters[':country']);
        $stmt->bindParam(':type',$pdo_parameters[':type']);
        $stmt->bindParam(':state',$pdo_parameters[':state']);
        $stmt->bindParam(':postcrossing_id',$pdo_parameters[':postcrossing_id']);
        $stmt->bindParam(':date',$pdo_parameters[':date']);
        $stmt->bindParam(':favorite',$pdo_parameters[':favorite']);;
        $stmt->bindParam(':photo',$blob,PDO::PARAM_LOB);
        $stmt->execute();
        
        header('Location: ' . 'add.php?msg=ok');
    } catch (PDOException $e) {
        header('Location: ' . 'add.php?msg=error');
    }
}
        