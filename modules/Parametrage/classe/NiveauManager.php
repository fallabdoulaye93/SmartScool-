<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Niveau.php');
require_once("../manager.php");

class NiveauManager extends manager{
    protected $_listNiveaux; // array
    protected $_nbreNiveau;

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
        $this->_listNiveaux[] = $obj;
        $this->_nbreNiveau++;

    }

    // liste de tous les abonnements
    public function getNiveaux($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Niveau($donnee));
        }
        return $this->getListNiveaux();

    }

    //liste d'un abonnement
    public function getNiveau($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Niveau($donnee));
        }
        return $this->getListNiveaux();
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
    public function getListNiveaux()
    {
        return $this->_listNiveaux;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListNiveaux($listNiveaux)
    {
        $this->_listNiveaux = $listNiveaux;
    }

    /**
     * @return mixed
     */
    public function getNbreNiveau()
    {
        return $this->_nbreNiveau;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreNiveau($nbreNiveau)
    {
        $this->_nbreNiveau = $nbreNiveau;
    }





}
