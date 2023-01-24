<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/TypeSanction.php');
require_once("../manager.php");

class TypeSanctionManager extends manager{
    protected $_listTypeSanctions; // array
    protected $_nbreTypeSanction;

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
        $this->_listTypeSanctions[] = $obj;
        $this->_nbreTypeSanction++;

    }

    // liste de tous les abonnements
    public function getTypeSanctions($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new TypeSanction($donnee));
        }
        return $this->getListTypeSanctions();

    }

    //liste d'un abonnement
    public function getTypeSanction($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new TypeSanction($donnee));
        }
        return $this->getListTypeSanctions();
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
    public function getListTypeSanctions()
    {
        return $this->_listTypeSanctions;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListTypeSanctions($listTypeSanctions)
    {
        $this->_listTypeSanctions = $listTypeSanctions;
    }

    /**
     * @return mixed
     */
    public function getNbreTypeSanction()
    {
        return $this->_nbreTypeSanction;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreTypeSanction($nbreTypeSanction)
    {
        $this->_nbreTypeSanction = $nbreTypeSanction;
    }





}
