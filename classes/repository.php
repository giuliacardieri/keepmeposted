<?php

require_once 'database.php';

class Repository {

    /**
     * Fetch everything from the database.
     * @return Array $data Returns array with all objects from the table.
     */
    public static function getPostcard() {
        $data = array();
        try {
            $db = Database::getInstance();
            $sql = 'SELECT * FROM postcards';
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return;
        }
        return $data;
    }   
  
    /**
     * Selects a postcard with a certain ID.
     * @param Integer $id The postcards' ID.
     * @return $data All attributes from the selected postcard.
    */
    public static function getPostcardId($id) {
        $data = null;
        try {
            $db = Database::getInstance();
            $sql = 'SELECT * FROM postcards WHERE id = :id';
            $stmt = $db->prepare($sql);
            $stmt->execute(array(':id' => $id));
            $data = $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
        
        return $data;
    }
  
    /**
       * Selects all postcards with a certain category.
       * @param Integer $cat The postcards' category.
       * @return $data All attributes from the selected postcard.
      */
      public static function getPostcardCategory($cat) {
          $data = array();
          try {
              $db = Database::getInstance();
              $sql = 'SELECT * FROM postcards WHERE category = :category';
              $stmt = $db->prepare($sql);
              $stmt->execute(array(':category' => $cat));
              $data = $stmt->fetchAll(PDO::FETCH_OBJ);
          } catch (PDOException $ex) {
              echo $ex->getMessage();
              return;
          }

          return $data;
      }

    /**
     * Searchs a string in a field from the Postcards table.
     * @param String $field The field to be searched
     * @param String $search  The string that represents the keyword that will be searched.
     * @return Array $data All postcards that matches the search requisites.
     */
    public static function getPostcardSearch($field, $query) { 
      $data = array();
        try {
            $db = Database::getInstance();
            $sql = 'SELECT * FROM postcards WHERE '.$field.' LIKE :query';
            $stmt = $db->prepare($sql);
            $stmt->execute(array(':query' => '%'.$query.'%'));
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return;
        }
        
        return $data;
    }
}
