<?php

require_once "models/Model.php";

class StudiosManager extends Model{
    public function getStudios(){
        $req = "SELECT * from studio";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $studios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $studios;
    }

    public function addStudioInstrument($idInstrument,$idStudio){
        $req ="Insert into instrument_studio (instrument_id,studio_id)
            values (:idInstrument,:idStudio)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idInstrument",$idInstrument,PDO::PARAM_INT);
        $stmt->bindValue(":idStudio",$idStudio,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function deleteDBStudioInstrument($idInstrument,$idStudio){
        $req ="Delete from instrument_studio
        where instrument_id = :idInstrument and studio_id = :idStudio";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idInstrument",$idInstrument,PDO::PARAM_INT);
        $stmt->bindValue(":idStudio",$idStudio,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function verificationExistenceInstrumentStudio($idInstrument,$idStudio){ //la fonction permet de tester si le nombre de ligne > 0, alors la ligne est bien présente en bdd
        $req ="Select count(*) as 'nb'
        from instrument_studio istud
        where istud_instrument_id = :idInstrument and istud_studioId = :idStudio";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idInstrument",$idInstrument,PDO::PARAM_INT);
        $stmt->bindValue(":idStudio",$idStudio,PDO::PARAM_INT);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if($resultat['nb'] >= 1) return true;
        return false;
    }
}