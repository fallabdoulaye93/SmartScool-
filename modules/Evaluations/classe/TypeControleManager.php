<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/TypeControle.php');
require_once("../manager.php");

class TypeControleManager extends manager{
    protected $_listTypeControles; // array
    protected $_nbreTypeControle;

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
        $this->_listTypeControles[] = $obj;
        $this->_nbreTypeControle++;

    }

    // liste de tous les abonnements
    public function getTypeControles($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new TypeControle($donnee));
        }
        return $this->getListTypeControles();

    }

    //liste d'un abonnement
    public function getTypeControle($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new TypeControle($donnee));
        }
        return $this->getListTypeControles();
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
    public function getListTypeControles()
    {
        return $this->_listTypeControles;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListTypeControles($listTypeControles)
    {
        $this->_listTypeControles = $listTypeControles;
    }

    /**
     * @return mixed
     */
    public function getNbreTypeControle()
    {
        return $this->_nbreTypeControle;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreTypeControle($nbreTypeControle)
    {
        $this->_nbreTypeControle = $nbreTypeControle;
    }





}
