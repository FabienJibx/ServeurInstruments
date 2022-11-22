<?php
require_once "models/Model.php";

class APIManager extends Model{
    //la fonction me permet de récupérer l'ensemble des tables de ma bdd en assurant les jointures entre elles
    public function getDBInstruments($idFamily, $idStudio){
        $whereClause = "";
        if($idFamily !== -1 || $idStudio !== -1) $whereClause .= "WHERE ";
        if($idFamily !== -1) $whereClause .= "f.family_id = :idFamily";
        if($idFamily !== -1 && $idStudio !== -1) $whereClause .=" AND ";
        if($idStudio !== -1) $whereClause .= "s.studio_id IN (
            select instrument_id from instrument_studio where studio_id = :idStudio
        )";

        $req = "SELECT i.instrument_id, instrument_nom, instrument_description, instrument_image, f.family_id, family_libelle, family_description, s.studio_id, studio_libelle
        from instrument i inner join family f on f.family_id = i.family_id
        left join instrument_studio istud on istud.instrument_id = i.instrument_id
        left join studio s on s.studio_id = istud.studio_id " .$whereClause;
        $stmt = $this->getBdd()->prepare($req);
        if($idFamily !== -1) $stmt->bindValue(":idFamily",$idFamily,PDO::PARAM_INT);
        if($idStudio !== -1) $stmt->bindValue(":idStudio",$idStudio,PDO::PARAM_INT);
        $stmt->execute();
        $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $instruments;
    }

    public function getDBInstrument($idInstrument){
        $req = "SELECT * 
        from instrument i inner join family f on f.family_id = i.family_id
        inner join instrument_studio istud on istud.instrument_id = i.instrument_id
        inner join studio s on s.studio_id = istud.studio_id
        WHERE i.instrument_id = :idInstrument
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idInstrument",$idInstrument,PDO::PARAM_INT);
        $stmt->execute();
        $lignesInstrument = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesInstrument;
    }

    public function getDBFamilys(){
        $req = "SELECT * 
        from family
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $familys = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $familys;
    }

    public function getDBStudios(){
        $req = "SELECT * 
        from studio
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $studios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $studios;
    }

    public function getDBStudio($idStudio){
        $req = "SELECT * 
        from instrument i inner join family f on f.family_id = i.family_id
        inner join instrument_studio istud on istud.instrument_id = i.instrument_id
        inner join studio s on s.studio_id = istud.studio_id
        WHERE s.studio_id = :idStudio
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idStudio",$idStudio,PDO::PARAM_INT);
        $stmt->execute();
        $lignesStudio = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesStudio;
    }
}