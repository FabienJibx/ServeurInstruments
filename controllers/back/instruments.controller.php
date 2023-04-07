<?php
require_once "./controllers/back/Security.class.php";
require_once "./models/back/instruments.manager.php";
require_once "./models/back/familys.manager.php";
require_once "./models/back/studios.manager.php";
require_once "./controllers/back/utile.php";

class InstrumentsController{
    private $instrumentsManager;

    public function __construct(){
       $this->instrumentsManager = new InstrumentsManager();
    }

    public function visualisation(){
        if(Securite::verifAccessSession()){
            $instruments = $this->instrumentsManager->getInstruments();
            require_once "views/instrumentsVisualisation.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function suppression(){
        if(Securite::verifAccessSession()){
            $idInstrument = (int)Securite::secureHTML($_POST['instrument_id']);
            $image = $this->instrumentsManager->getInstrumentImage($idInstrument);
            unlink("public/images".$image);
            
            $this->instrumentsManager->deleteDBinstrumentStudio($idInstrument);
            $this->instrumentsManager->deleteDBinstrument($idInstrument);
            $_SESSION['alert'] = [
                "message" => "L'instrument est supprimé",
                "type" => "alert-success"
            ];
           
            header('Location: '.URL.'back/instruments/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function creation(){
        if(Securite::verifAccessSession()){
            $familysManager = new FamilysManager();
            $familys = $familysManager->getFamilys();
            $studiosManager = new StudiosManager();
            $studios = $studiosManager->getStudios();
            require_once "views/instrumentCreation.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function creationValidation(){
        if(Securite::verifAccessSession()){
            $nom = Securite::secureHTML($_POST['instrument_nom']);
            $description = Securite::secureHTML($_POST['instrument_description']);
            $image ="";
            if($_FILES['image']['size'] > 0){
                $repertoire = "public/images/";
                $image = ajoutImage($_FILES['image'],$repertoire);
            }

            $family = (int) Securite::secureHTML($_POST['family_id']);

            $idInstrument = $this->instrumentsManager->createInstrument($nom,$description,$image,$family);

            $studiosManager = new StudiosManager();
            if(!empty($_POST['studio-1']))
                $studiosManager->addStudioInstrument($idInstrument,1);
            if(!empty($_POST['studio-2']))
                $studiosManager->addStudioInstrument($idInstrument,2);
            if(!empty($_POST['studio-3']))
                $studiosManager->addStudioInstrument($idInstrument,3);
            if(!empty($_POST['studio-4']))
                $studiosManager->addStudioInstrument($idInstrument,4);

            $_SESSION['alert'] = [
                "message" => "L'instrument est crée avec l'id : ".$idInstrument,
                "type" => "alert-success"
            ];
            header('Location: '.URL.'back/instruments/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function modification($idInstrument){
        if(Securite::verifAccessSession()){
            $familysManager = new FamilysManager();
            $familys = $familysManager->getFamilys();
            $studiosManager = new StudiosManager();
            $studios = $studiosManager->getStudios();
            
            $lignesInstrument = $this->instrumentsManager->getInstrument((int)Securite::secureHTML($idInstrument));
            $tabStudios = [];
            foreach($lignesInstrument as $studio){
                $tabStudios[] = $studio['studio_id'];
            }
            $instrument = array_slice($lignesInstrument[0],0,5); //cette variable me permet d'appeler les 5 premiéres entrées du tableau plus facilement

            require_once "views/instrumentModification.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function modificationValidation(){
        if(Securite::verifAccessSession()){
            $idInstrument = Securite::secureHTML($_POST['instrument_id']);
            $nom = Securite::secureHTML($_POST['instrument_nom']);
            $description = Securite::secureHTML($_POST['instrument_description']);
            $image = $this->instrumentsManager->getInstrumentImage($idInstrument);
            if($_FILES['image']['size'] > 0 ){
                unlink("public/images".$image);
                $repertoire = "public/images/";
                $image = ajoutImage($_FILES['image'],$repertoire);
            }
            
            $family = (int) Securite::secureHTML($_POST['family_id']);

            $this->instrumentsManager->updateInstrument($idInstrument,$nom,$description,$image,$family);
            
            $studiosManager = new StudiosManager;

            $studios = [
                1 => !empty($_POST['studio-1']),
                2 => !empty($_POST['studio-2']),
                3 => !empty($_POST['studio-3']),
                4 => !empty($_POST['studio-4']),
            ];

            foreach ($studios as $key => $studio) {
                //studio coché et non présent en BDD
                if($studios[$key] && !$studiosManager->verificationExistenceInstrumentStudio($idInstrument,$key)){
                    $studiosManager->addStudioInstrument($idInstrument,$key);
                }

                //studio non coché et présent en BDD
                if(!$studios[$key] && $studiosManager->verificationExistenceInstrumentStudio($idInstrument,$key)){
                    $studiosManager->deleteDBStudioInstrument($idInstrument,$key);
                }
            }

            $_SESSION['alert'] = [
                "message" => "L'instrument a bien été modifié",
                "type" => "alert-success"
            ];
            header('Location: '.URL.'back/instruments/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }


}