<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Etablissement.php');
require_once("../manager.php");

class EtablissementManager extends manager{
    protected $_listEtablissements; // array
    protected $_nbreEtablissement;

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
        $this->_listEtablissements[] = $obj;
        $this->_nbreEtablissement++;

    }

    // liste de tous les abonnements
    public function getEtablissements($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Etablissement($donnee));
        }
        return $this->getListEtablissements();

    }

    //liste d'un abonnement
    public function getEtablissement($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Etablissement($donnee));
        }
        return $this->getListEtablissements();
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
    public function getListEtablissements()
    {
        return $this->_listEtablissements;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListEtablissements($listEtablissements)
    {
        $this->_listEtablissements = $listEtablissements;
    }

    /**
     * @return mixed
     */
    public function getNbreEtablissement()
    {
        return $this->_nbreEtablissement;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreEtablissement($nbreEtablissement)
    {
        $this->_nbreEtablissement = $nbreEtablissement;
    }





}
