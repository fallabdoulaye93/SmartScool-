<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/TypeSalle.php');
require_once("../manager.php");

class TypeSalleManager extends manager{
    protected $_listTypeSalles; // array
    protected $_nbreTypeSalle;

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
        $this->_listTypeSalles[] = $obj;
        $this->_nbreTypeSalle++;

    }

    // liste de tous les abonnements
    public function getTypeSalles($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new TypeSalle($donnee));
        }
        return $this->getListTypeSalles();

    }

    //liste d'un abonnement
    public function getTypeSalle($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new TypeSalle($donnee));
        }
        return $this->getListTypeSalles();
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
    public function getListTypeSalles()
    {
        return $this->_listTypeSalles;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListTypeSalles($listTypeSalles)
    {
        $this->_listTypeSalles = $listTypeSalles;
    }

    /**
     * @return mixed
     */
    public function getNbreTypeSalle()
    {
        return $this->_nbreTypeSalle;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreTypeSalle($nbreTypeSalle)
    {
        $this->_nbreTypeSalle = $nbreTypeSalle;
    }





}
