<?php
require_once "./controllers/back/Security.class.php";
require_once "./models/back/familys.manager.php";

class FamilysController{
    private $familysManager;

    public function __construct(){
        $this->familysManager = new FamilysManager();
    }

    public function visualisation(){
        if(Securite::verifAccessSession()){
            $familys = $this->familysManager->getFamilys();
            require_once "views/familysVisualisation.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function suppression(){
        if(Securite::verifAccessSession()){
            $idFamily = (int)Securite::secureHTML($_POST['family_id']);
            
            if($this->familysManager->compterInstruments($idFamily) > 0){
                $_SESSION['alert'] = [
                    "message" => "La famille n'a pas été supprimé",
                    "type" => "alert-danger"
                ];
            } else {
                $this->familysManager->deleteDBfamily($idFamily);
                $_SESSION['alert'] = [
                    "message" => "La famille est supprimée",
                    "type" => "alert-success"
                ];
            }
           
            header('Location: '.URL.'back/familles/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function modification(){
        if(Securite::verifAccessSession()){
            $idFamily = (int) Securite::secureHTML($_POST['family_id']);
            $libelle = Securite::secureHTML($_POST['family_libelle']);
            $description = Securite::secureHTML($_POST['family_description']);
            $this->familysManager->updateFamily($idFamily,$libelle,$description);

            $_SESSION['alert'] = [
                "message" => "La famille a bien été modifiée",
                "type" => "alert-success"
            ];

            header('Location: '.URL.'back/familles/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function modificationFamily()
    {
        if (Securite::verifAccessSession()) {
            $id = (int) Securite::secureHTML($_POST['family_id']);
            $family = $this->familysManager->getFamily($id);
            require_once "views/family-form.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function creationTemplate(){
        if(Securite::verifAccessSession()){
            require_once "views/familyCreation.view.php";
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }

    public function creationValidation(){
        if(Securite::verifAccessSession()){
            $libelle = Securite::secureHTML($_POST['family_libelle']);
            $description = Securite::secureHTML($_POST['family_description']);
            $idFamily = $this->familysManager->createFamily($libelle,$description);

            $_SESSION['alert'] = [
                "message" => "La famille a bien été crée avec l'identifiant : ".$idFamily,
                "type" => "alert-success"
            ];

            header('Location: '.URL.'back/familles/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        } 
    }
}