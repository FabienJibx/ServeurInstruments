<?php

require_once "models/Model.php";

class InstrumentsManager extends Model{
    public function getInstruments(){
        $req = "SELECT * from instrument";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $instruments;
    }

    public function deleteDBinstrument($idInstrument){
        $req ="Delete from instrument where instrument_id= :idInstrument";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idInstrument",$idInstrument,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    
    public function deleteDBinstrumentStudio($idInstrument){
        $req ="Delete from instrument_studio where instrument_id= :idInstrument";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idInstrument",$idInstrument,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    public function updateInstrument($idInstrument,$nom,$description,$image,$family){
        $req ="Update instrument
        set instrument_nom = :nom, instrument_description = :description, instrument_image = :image, family_id = :famille
        where instrument_id= :idInstrument";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idInstrument",$idInstrument,PDO::PARAM_INT);
        $stmt->bindValue(":nom",$nom,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":family",$family,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    public function createInstrument($libelle,$description,$image,$family){
        $req ="Insert into instrument (instrument_nom,instrument_description,instrument_image,family_id)
            values (:libelle,:description,:image,:family)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":libelle",$libelle,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":family",$family,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        return $this->getBdd()->lastInsertId();
    }

    public function getInstrument($idInstrument){
        $req ="SELECT i.instrument_id, instrument_nom, instrument_description, instrument_image, i.family_id, studio_id from instrument i
            inner join family f on i.family_id = f.family_id
            left join instrument_studio istud on istud.instrument_id = i.instrument_id
            WHERE i.instrument_id = :idInstrument";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idInstrument",$idInstrument,PDO::PARAM_INT);
        $stmt->execute();
        $lignesInstrument = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesInstrument;
    }

    public function getInstrumentImage($idInstrument){
        $req = "SELECT instrument_image from instrument where instrument_id = :idInstrument";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idInstrument",$idInstrument,PDO::PARAM_INT);
        $stmt->execute();
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $image['instrument_image'];
    }


}