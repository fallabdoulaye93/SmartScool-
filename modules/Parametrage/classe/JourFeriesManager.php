<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/JourFeries.php');
require_once("../manager.php");

class JourFeriesManager extends manager{
    protected $_listJFs; // array
    protected $_nbreJF;

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
        $this->_listJFs[] = $obj;
        $this->_nbreJF++;

    }

    // liste de tous les abonnements
    public function getJourFeries($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new JourFeries($donnee));
        }
        return $this->getListJFs();

    }

    //liste d'un abonnement
    public function getJourFerie($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new JourFeries($donnee));
        }
        return $this->getListJFs();
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
    public function getListJFs()
    {
        return $this->_listJFs;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListJFs($listJFs)
    {
        $this->_listJFs = $listJFs;
    }

    /**
     * @return mixed
     */
    public function getNbreJF()
    {
        return $this->_nbreJF;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreJF($nbreJF)
    {
        $this->_nbreJF = $nbreJF;
    }





}
