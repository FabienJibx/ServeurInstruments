<?php
require_once "models/front/API.manager.php";
require_once "models/Model.php";

class APIController {
    private $apiManager;

    public function __construct(){
        $this->apiManager = new APIManager();
    }

    public function getInstruments($idFamily,$idStudio){
        $instruments = $this->apiManager->getDBInstruments($idFamily,$idStudio);
        $tabResult = $this->dataFormatLignesInstruments($instruments);
        // echo "<pre>";
        // print_r($tabResult);
        // echo "</pre>";
        Model::sendJSON($tabResult);
    }

    public function getInstrument($idInstrument){
        $lignesInstrument = $this->apiManager->getDBInstrument($idInstrument);
        $tabResult = $this->dataFormatLignesInstruments($lignesInstrument);
        Model::sendJSON($tabResult);
    }

    private function dataFormatLignesInstruments($lignes){
        $tab = [];
        foreach($lignes as $ligne){
            if(!array_key_exists($ligne['instrument_id'],$tab)){
                $tab[$ligne['instrument_id']] = [
                    "id" => $ligne['instrument_id'],
                    "nom" => $ligne['instrument_nom'],
                    "description" => $ligne['instrument_description'],
                    "image" => URL."public/images/".$ligne['instrument_image'],
                    "family" => [
                        "idFamily" => $ligne['family_id'],
                        "libelleFamily" => $ligne['family_libelle'],
                        "descriptionFamily" => $ligne['family_description']
                    ]
                ];    
            }
            
                $tab[$ligne['instrument_id']]['studios'][] = [
                    "idStudio" => $ligne['studio_id'],
                    "libelleStudio" => $ligne['studio_libelle']
                ];
        }

        return $tab;  
    }

    public function getFamilys(){
        $familys = $this->apiManager->getDBFamilys();
        Model::sendJSON($familys);
        //echo "<pre>";
        //print_r($familys);
        //echo "</pre>";
    }

    public function getStudios(){
        $studios = $this->apiManager->getDBStudios();
        Model::sendJSON($studios);
        //echo "<pre>";
        //print_r($studios);
        //echo "</pre>";
    }

    public function getStudio($idStudio){
        $lignesStudio = $this->apiManager->getDBStudio($idStudio);
        echo "<pre>";
        print_r($lignesStudio);
        echo "</pre>";
    } 

    public function sendMessage(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Accept, Content-type, Content-length, Accept-encoding");
        header("Content-Type: application/json");

        $obj = json_decode(file_get_contents('php://input'));

        

        $messageRetour = [
            'from' => $obj->email,
            'to' => "contact@kelmatos.fr"
        ];

        echo json_encode("ok");
    }
}