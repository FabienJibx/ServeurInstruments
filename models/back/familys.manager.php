<?php

require_once "models/Model.php";

class FamilysManager extends Model{
    public function getFamilys(){
        $req = "SELECT * from family";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $familys = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $familys;
    }

    public function getFamily($id)
    {
        $req = "SELECT * from family WHERE family_id=:id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $family = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $family;
    }

    public function deleteDBfamily($idFamily){
        $req ="Delete from family where family_id= :idFamily";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idFamily",$idFamily,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function compterInstruments($idFamily){
        $req ="Select count(*) as 'nb'
        from family f inner join instrument i on i.family_id = f.family_id
        where f.family_id = :idFamily";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idFamily",$idFamily,PDO::PARAM_INT);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultat['nb'];
    }

    public function updateFamily($idFamily,$libelle,$description){
        $req ="Update family set family_libelle = :libelle, family_description = :description
        where family_id= :idFamily";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idFamily",$idFamily,PDO::PARAM_INT);
        $stmt->bindValue(":libelle",$libelle,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function createFamily($libelle,$description){
        $req ="Insert into family (family_libelle,family_description)
            values (:libelle,:description)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":libelle",$libelle,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        return $this->getBdd()->lastInsertId();
    }
}