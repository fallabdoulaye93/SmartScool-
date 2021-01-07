<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/SortieEquipement.php');
require_once("../manager.php");

class SortieEquipementManager extends manager{
    protected $_listSortieEquipements; // array
    protected $_nbreSortieEquipement;

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
        $this->_listSortieEquipements[] = $obj;
        $this->_nbreSortieEquipement++;

    }

    // liste de tous les abonnements
    public function getSortieEquipements($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new SortieEquipement($donnee));
        }
        return $this->getListSortieEquipements();

    }

    //liste d'un abonnement
    public function getSortieEquipement($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new SortieEquipement($donnee));
        }
        return $this->getListSortieEquipements();
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
    public function getListSortieEquipements()
    {
        return $this->_listSortieEquipements;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListSortieEquipements($listSortieEquipements)
    {
        $this->_listSortieEquipements = $listSortieEquipements;
    }

    /**
     * @return mixed
     */
    public function getNbreSortieEquipement()
    {
        return $this->_nbreSortieEquipement;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreSortieEquipement($nbreSortieEquipement)
    {
        $this->_nbreSortieEquipement = $nbreSortieEquipement;
    }





}
