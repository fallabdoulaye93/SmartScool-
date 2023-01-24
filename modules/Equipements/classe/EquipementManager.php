<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Equipement.php');
require_once("../manager.php");

class EquipementManager extends manager{
    protected $_listEquipements; // array
    protected $_nbreEquipement;

    /**
     * EvenementManager constructor.
     * @param $_db
     * @param $_table
     */
    public function __construct($db,$table)
    {
        parent::__construct($db,$table);
    }
    public function add($obj)
    {
        $this->_listEquipements[] = $obj;
        $this->_nbreEquipement++;

    }

    // liste de tous les abonnements
    public function getEquipements($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Equipement($donnee));
        }
        return $this->getListEquipements();

    }

    //liste d'un abonnement
    public function getEquipement($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Equipement($donnee));
        }
        return $this->getListEquipements();
    }


    function insert($values) {
        $donnees=parent::insert($values);
        return $donnees;
    }



    function modifier($values,$idField,$idValue) {
        $info=parent::modifier($values,$idField,$idValue);
        return $info;
    }

    public function supprimer($fieldId,$idValue)
    {
        $info=parent::supprimer($fieldId,$idValue);
        return $info;
    }

    /**
     * @return mixed
     */
    public function getListEquipements()
    {
        return $this->_listEquipements;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListEquipements($listEquipements)
    {
        $this->_listEquipements = $listEquipements;
    }

    /**
     * @return mixed
     */
    public function getNbreEquipement()
    {
        return $this->_nbreEquipement;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreEquipement($nbreEquipement)
    {
        $this->_nbreEquipement = $nbreEquipement;
    }





}
