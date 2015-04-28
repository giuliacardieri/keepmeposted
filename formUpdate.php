<?php
require_once 'globals.php';
require_once 'classes/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $description =   trim($_POST['description']);
    $sender =  trim($_POST['sender']);
    $category = trim($_POST['category']);
    $country =  trim($_POST['country']);
    $type =  trim($_POST['type']);
    $state = trim($_POST['state']);
    $postcrossing_id = trim($_POST['postcrossing_id']);
    $date = trim($_POST['date']);
    $favorite = trim($_POST['favorite']);
    $id = trim($_POST['id']);
  
    // if wants to update the photo
    if (file_exists($_FILES['photo']['tmp_name'])){
      $name  = $_FILES['photo']['tmp_name'];
      $blob = fopen($name,'rb');
      $photo = 'photo';
      $new_photo = true;
      $update = "UPDATE postcards SET description = :description, 
                                    sender = :sender, 
                                    category = :category, 
                                    country = :country, 
                                    type = :type, 
                                    state = :state, 
                                    postcrossing_id = :postcrossing_id, 
                                    date = :date, 
                                    favorite = :favorite, 
                                    photo = :photo 
                                    WHERE ID = :id";
    }
    else {
      $new_photo = false;    
      $update = "UPDATE postcards SET description = :description, 
                                    sender = :sender, 
                                    category = :category, 
                                    country = :country, 
                                    type = :type, 
                                    state = :state, 
                                    postcrossing_id = :postcrossing_id, 
                                    date = :date, 
                                    favorite = :favorite 
                                    WHERE ID = :id";
    }


    try { 
        $db = database::getInstance();
        $stmt = $db->prepare($update);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':sender',$sender);
        $stmt->bindParam(':category',$category);
        $stmt->bindParam(':country',$country);
        $stmt->bindParam(':type',$type);
        $stmt->bindParam(':state',$state);
        $stmt->bindParam(':postcrossing_id',$postcrossing_id);
        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':favorite',$favorite);
        $stmt->bindParam(':id',$id);
        if ($photo_nova)
          $stmt->bindParam(':photo',$blob,PDO::PARAM_LOB);
        $stmt->execute();
      
        header('Location: postcard.php?id='.$id);
    } catch (PDOException $e) {
        header('Location: postcard.php?id='.$id);
      echo $e;
    }
}
?>