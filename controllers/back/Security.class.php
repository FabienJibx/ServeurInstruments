<?php
    class Securite{
        public static function secureHTML($string){
            return htmlentities($string);           //htmlentities permet de convertir les caractéres spéciaux en caractére html, permet d'éviter les injections bizarres et de sécuriser
        }

        public static function verifAccessSession(){
            return (!empty($_SESSION['access']) && $_SESSION['access'] === "admin");
        }
    }
    
?>