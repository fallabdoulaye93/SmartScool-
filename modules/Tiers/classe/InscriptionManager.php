<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Inscription.php');
require_once("../manager.php");

class InscriptionManager extends manager{
    protected $_listInscriptions; // array
    protected $_nbreInscription;

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
        $this->_listInscriptions[] = $obj;
        $this->_nbreInscription++;

    }

    // liste de tous les abonnements
    public function getInscriptions($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Inscription($donnee));
        }
        return $this->getListInscriptions();

    }

    //liste d'un abonnement
    public function getInscription($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Inscription($donnee));
        }
        return $this->getListInscriptions();
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
    public function getListInscriptions()
    {
        return $this->_listInscriptions;
    }

    /**
     * @param mixed $listInscriptions
     */
    public function setListInscriptions($listInscriptions)
    {
        $this->_listInscriptions = $listInscriptions;
    }

    /**
     * @return mixed
     */
    public function getNbreInscription()
    {
        return $this->_nbreInscription;
    }

    /**
     * @param mixed $nbreInscription
     */
    public function setNbreInscription($nbreInscription)
    {
        $this->_nbreInscription = $nbreInscription;
    }







}
