<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Filiere.php');
require_once("../manager.php");

class FiliereManager extends manager{
    protected $_listFilieres; // array
    protected $_nbreFiliere;

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
        $this->_listFilieres[] = $obj;
        $this->_nbreFiliere++;

    }

    // liste de tous les abonnements
    public function getFilieres($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Filiere($donnee));
        }
        return $this->getListFilieres();

    }

    public function supprimer($fieldId,$idValue)
    {
        $info=parent::supprimer($fieldId,$idValue);
        return $info;
    }

    //liste d'un abonnement
    public function getFiliere($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Filiere($donnee));
        }
        return $this->getListFilieres();
    }


    function insert($values) {
        $donnees=parent::insert($values);
        return $donnees;
    }



    function modifier($values,$idField,$idValue) {
        $info=parent::modifier($values,$idField,$idValue);
        return $info;
    }

    /**
     * @return mixed
     */
    public function getListFilieres()
    {
        return $this->_listFilieres;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListFilieres($listFilieres)
    {
        $this->_listFilieres = $listFilieres;
    }

    /**
     * @return mixed
     */
    public function getNbreFiliere()
    {
        return $this->_nbreFiliere;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreFiliere($nbreFiliere)
    {
        $this->_nbreFiliere = $nbreFiliere;
    }





}
