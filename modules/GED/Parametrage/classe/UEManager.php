<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/UE.php');
require_once("../manager.php");

class UEManager extends manager{
    protected $_listUEs; // array
    protected $_nbreUE;

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
        $this->_listUEs[] = $obj;
        $this->_nbreUE++;

    }

    // liste de tous les abonnements
    public function getUEs($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new UE($donnee));
        }
        return $this->getListUEs();

    }

    //liste d'un abonnement
    public function getUE($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new UE($donnee));
        }
        return $this->getListUEs();
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
    public function getListUEs()
    {
        return $this->_listUEs;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListUEs($listUEs)
    {
        $this->_listUEs = $listUEs;
    }

    /**
     * @return mixed
     */
    public function getNbreUE()
    {
        return $this->_nbreUE;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreUE($nbreUE)
    {
        $this->_nbreUE = $nbreUE;
    }





}
