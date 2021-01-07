<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Classe.php');
require_once("../manager.php");

class ClasseManager extends manager{
    protected $_listClasses; // array
    protected $_nbreClasse;

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
        $this->_listClasses[] = $obj;
        $this->_nbreClasse++;

    }

    // liste de tous les abonnements
    public function getClasses($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Classe($donnee));
        }
        return $this->getListClasses();

    }

    //liste d'un abonnement
    public function getClasse($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Classe($donnee));
        }
        return $this->getListClasses();
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
    public function getListClasses()
    {
        return $this->_listClasses;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListClasses($listClasses)
    {
        $this->_listClasses = $listClasses;
    }

    /**
     * @return mixed
     */
    public function getNbreClasse()
    {
        return $this->_nbreClasse;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreClasse($nbreClasse)
    {
        $this->_nbreClasse = $nbreClasse;
    }





}
