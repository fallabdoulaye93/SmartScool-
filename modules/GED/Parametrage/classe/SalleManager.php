<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Salle.php');
require_once("../manager.php");

class SalleManager extends manager{
    protected $_listSalles; // array
    protected $_nbreSalle;

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
        $this->_listSalles[] = $obj;
        $this->_nbreSalle++;

    }

    // liste de tous les abonnements
    public function getSalles($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Salle($donnee));
        }
        return $this->getListSalles();

    }

    //liste d'un abonnement
    public function getSalle($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Salle($donnee));
        }
        return $this->getListSalles();
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
    public function getListSalles()
    {
        return $this->_listSalles;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListSalles($listSalles)
    {
        $this->_listSalles = $listSalles;
    }

    /**
     * @return mixed
     */
    public function getNbreSalle()
    {
        return $this->_nbreSalle;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreSalle($nbreSalle)
    {
        $this->_nbreSalle = $nbreSalle;
    }





}
