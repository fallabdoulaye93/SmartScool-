<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/PeriodeScolaire.php');
require_once("../manager.php");

class PeriodeScolaireManager extends manager{
    protected $_listPeriodeScolaires; // array
    protected $_nbrePeriodeScolaire;

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
        $this->_listPeriodeScolaires[] = $obj;
        $this->_nbrePeriodeScolaire++;

    }

    // liste de tous les abonnements
    public function getPeriodeScolaires($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new PeriodeScolaire($donnee));
        }
        return $this->getListPeriodeScolaires();

    }

    //liste d'un abonnement
    public function getPeriodeScolaire($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new PeriodeScolaire($donnee));
        }
        return $this->getListPeriodeScolaires();
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
    public function getListPeriodeScolaires()
    {
        return $this->_listPeriodeScolaires;
    }

    /**
     * @param mixed $listPeriodeScolaires
     */
    public function setListPeriodeScolaires($listPeriodeScolaires)
    {
        $this->_listPeriodeScolaires = $listPeriodeScolaires;
    }

    /**
     * @return mixed
     */
    public function getNbrePeriodeScolaire()
    {
        return $this->_nbrePeriodeScolaire;
    }

    /**
     * @param mixed $nbrePeriodeScolaire
     */
    public function setNbrePeriodeScolaire($nbrePeriodeScolaire)
    {
        $this->_nbrePeriodeScolaire = $nbrePeriodeScolaire;
    }







}
