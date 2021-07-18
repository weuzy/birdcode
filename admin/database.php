<?php
    session_start();
    ob_start();
    include 'connexionAdmin.php';
    class Database{

        private static $dbHost = "localhost"; 
        private static $dbName = "bird_code";
        private static $dbUser = "root";
        private static $dbUserPassword = "";

        private static $connexion = null;

        public static function connect(){

            try {
                self::$connexion = new PDO("mysql:host=" .self::$dbHost. ";dbname=" .self::$dbName, self::$dbUser, self::$dbUserPassword);
                self::$connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die($e -> getMessage());
            }
            $db = new Main(self::$connexion);
            return self::$connexion;

        }
        public static function disconnect(){
            self::$connexion = null;
        }

    }

    Database::connect();


















?>









