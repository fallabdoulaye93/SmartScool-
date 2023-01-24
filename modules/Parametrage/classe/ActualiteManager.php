<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Actualite.php');
require_once("../manager.php");

class ActualiteManager extends manager{
    protected $_listActualites; // array
    protected $_nbreActualite;

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
        $this->_listActualites[] = $obj;
        $this->_nbreActualite++;

    }

    // liste de tous les abonnements
    public function getActualites($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Actualite($donnee));
        }
        return $this->getListActualites();

    }

    //liste d'un abonnement
    public function getActualite($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Actualite($donnee));
        }
        return $this->getListActualites();
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
    public function getListActualites()
    {
        return $this->_listActualites;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListActualites($listActualites)
    {
        $this->_listActualites = $listActualites;
    }

    /**
     * @return mixed
     */
    public function getNbreActualite()
    {
        return $this->_nbreActualite;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreActualite($nbreActualite)
    {
        $this->_nbreActualite = $nbreActualite;
    }





}
