<?php
abstract class Model {
    private static $pdo;

    // la fonction suivante me sert à faire la connection à la bdd
    private static function setBdd(){
        self::$pdo = new PDO("mysql:host=localhost;dbname=dbinstruments;charset=utf8","root","");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }

    // si une connection a déjà eu lieu la fonction suivante récupére l'instance
    protected function getBdd(){
        if(self::$pdo === null){
            self::setBdd();
        }
        return self::$pdo;
    }

    public static function sendJSON($info){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($info);
    }
}