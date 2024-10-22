<?php
class DB {

    public static $salt = 'd41d8cd98f00b204e9800998ecf8427e';
    private static $instance;

    private function __construct(){
        
    }

    public static function getInstance(){
        if(!self::$instance){

            $conex = new mysqli('localhost','root','','dbtfg');

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            self::$instance = $conex;
        }
        return self::$instance;     
    }

}

?>