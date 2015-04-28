<?php

class database extends PDO{
    // accessing the mysql database
    private static $DB_NAME = 'keepmeposted';
    private static $DB_HOST = 'localhost';
    private static $DB_USER = 'root';
    private static $DB_PWD = 'lolala';
    private static $database = null;
    
    // created a PDO instance that represents the access to the database.
    public function __construct() {
        $dsn = 'mysql:host=' . self::$DB_HOST . ';dbname=' . self::$DB_NAME;
        parent::__construct($dsn, self::$DB_USER, self::$DB_PWD);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    // creates a new table if necessary
    public static function getInstance(){
        if(self::$database === null){
            self::$database = new database();
        }
        return self::$database;
    }
}
