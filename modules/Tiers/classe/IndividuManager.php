<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Individu.php');
require_once("../manager.php");

class IndividuManager extends manager{
    protected $_listIndividus; // array
    protected $_nbreIndividu;

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
        $this->_listIndividus[] = $obj;
        $this->_nbreIndividu++;

    }

    // liste de tous les abonnements
    public function getIndividus($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Individu($donnee));
        }
        return $this->getListIndividus();

    }

    //liste d'un abonnement
    public function getIndividu($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Individu($donnee));
        }
        return $this->getListIndividus();
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
    public function getListIndividus()
    {
        return $this->_listIndividus;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListIndividus($listIndividus)
    {
        $this->_listIndividus = $listIndividus;
    }

    /**
     * @return mixed
     */
    public function getNbreIndividu()
    {
        return $this->_nbreIndividu;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreIndividu($nbreIndividu)
    {
        $this->_nbreIndividu = $nbreIndividu;
    }





}
