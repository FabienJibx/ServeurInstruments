<?php 
session_start();

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http").
"://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/front/API.controller.php";
require_once "controllers/back/admin.controller.php";
require_once "controllers/back/familys.controller.php";
require_once "controllers/back/instruments.controller.php";
$apiController = new APIController();
$adminController = new AdminController();
$familysController = new FamilysController();
$instrumentsController = new InstrumentsController();

try{
    if(empty($_GET['page'])){
        throw new Exception("La page n'existe pas ");
    } else {
        $url = explode("/",filter_var($_GET['page'],FILTER_SANITIZE_URL));
        if(empty($url[0]) || empty($url[1])) throw new Exception ("La page n'existe pas ");
        switch($url[0]){
            case "front" : 
                switch($url[1]){
                    case "instruments": 
                        if(!isset($url[2]) || !isset($url[3])){
                            $apiController -> getInstruments(-1,-1);
                        } else {
                            $apiController -> getInstruments((int)$url[2],(int)$url[3]);
                        }
                    break;
                    case "instrument": 
                        if(empty($url[2])) throw new Exception ("L'identifiant de l'instrument est manquant ");
                        $apiController -> getInstrument($url[2]);
                    break;
                    case "studios": $apiController -> getStudios();
                    break;
                    case 'studio':
                        if(empty($url[2])) throw new Exception ("L'identifiant du studio est manquant ");
                        $apiController -> getStudio($url[2]);
                    break;
                    case "familys": $apiController -> getFamilys();
                    break;
                    default : throw new Exception ("La page n'existe pas ");
                }
                break;
                case "back" : 
                    switch($url[1]){
                        case "login" : $adminController->getPageLogin();
                        break;
                        case "connexion" : $adminController->connexion();
                        break;
                        case "admin" : $adminController->getAccueilAdmin();
                        break;
                        case "deconnexion" : $adminController->deconnexion();
                        break;
                        case "familles" :
                            switch($url[2]){
                                case "visualisation" : $familysController->visualisation();
                                break;
                                case "validationSuppression" : $familysController->suppression();
                                break;
                                case "modificationFamily": $familysController->modificationFamily();
                                break;
                                case "validationModification": $familysController->modification();
                                break;
                                case "creation" :$familysController->creationTemplate();
                                break;
                                case "creationValidation" : $familysController->creationValidation();
                                break;
                                default : throw new Exception ("La page n'existe pas ");
                            }
                        break;
                        case "instruments" :
                            switch($url[2]){
                                case "visualisation" : $instrumentsController->visualisation();
                                break;
                                case "validationSuppression" : $instrumentsController->suppression();
                                break;
                                case "creation" : $instrumentsController->creation();
                                break;
                                case "creationValidation" : $instrumentsController->creationValidation();
                                break;
                                case "modification" : $instrumentsController->modification($url[3]);
                                break;
                                case "modificationValidation" : $instrumentsController->modificationValidation();
                                break;
                                default : throw new Exception ("La page n'existe pas ");
                            }
                        break;
                        default : throw new Exception ("La page n'existe pas ");
                    }
                break;
                default : throw new Exception ("La page n'existe pas ");
                }
        }
} catch (Exception $e){
    $msg = $e->getMessage();
    echo $msg;
    echo "<a href='".URL."back/login'>login</a>";
}