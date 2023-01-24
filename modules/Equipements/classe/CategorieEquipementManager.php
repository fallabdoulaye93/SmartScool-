<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/CategorieEquipement.php');
require_once("../manager.php");

class CategorieEquipementManager extends manager{
    protected $_listCategorieEquipements; // array
    protected $_nbreCategorieEquipement;

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
        $this->_listCategorieEquipements[] = $obj;
        $this->_nbreCategorieEquipement++;

    }

    // liste de tous les abonnements
    public function getCategorieEquipements($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new CategorieEquipement($donnee));
        }
        return $this->getListCategorieEquipements();

    }

    //liste d'un abonnement
    public function getCategorieEquipement($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new CategorieEquipement($donnee));
        }
        return $this->getListCategorieEquipements();
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
    public function getListCategorieEquipements()
    {
        return $this->_listCategorieEquipements;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListCategorieEquipements($listCategorieEquipements)
    {
        $this->_listCategorieEquipements = $listCategorieEquipements;
    }

    /**
     * @return mixed
     */
    public function getNbreCategorieEquipement()
    {
        return $this->_nbreCategorieEquipement;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreCategorieEquipement($nbreCategorieEquipement)
    {
        $this->_nbreCategorieEquipement = $nbreCategorieEquipement;
    }





}
