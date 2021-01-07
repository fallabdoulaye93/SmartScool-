<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/AnneeScolaire.php');
require_once("../manager.php");

class AnneeScolaireManager extends manager{
    protected $_listAnneeScolaires; // array
    protected $_nbreAnneeScolaire;

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
        $this->_listAnneeScolaires[] = $obj;
        $this->_nbreAnneeScolaire++;

    }

    // liste de tous les abonnements
    public function getAnneeScolaires($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new AnneeScolaire($donnee));
        }
        return $this->getListAnneeScolaires();

    }

    //liste d'un abonnement
    public function getAnneeScolaire($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new AnneeScolaire($donnee));
        }
        return $this->getListAnneeScolaires();
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
    public function getListAnneeScolaires()
    {
        return $this->_listAnneeScolaires;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListAnneeScolaires($listAnneeScolaires)
    {
        $this->_listAnneeScolaires = $listAnneeScolaires;
    }

    /**
     * @return mixed
     */
    public function getNbreAnneeScolaire()
    {
        return $this->_nbreAnneeScolaire;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreAnneeScolaire($nbreAnneeScolaire)
    {
        $this->_nbreAnneeScolaire = $nbreAnneeScolaire;
    }





}
