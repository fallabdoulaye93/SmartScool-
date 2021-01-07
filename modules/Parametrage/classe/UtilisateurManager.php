<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Utilisateur.php');
require_once("../manager.php");

class UtilisateurManager extends manager{
    protected $_listUtilisateurs; // array
    protected $_nbreUtilisateur;

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
        $this->_listUtilisateurs[] = $obj;
        $this->_nbreUtilisateur++;

    }

    // liste de tous les abonnements
    public function getUtilisateurs($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new Utilisateur($donnee));
        }
        return $this->getListUtilisateurs();

    }

    //liste d'un abonnement
    public function getUtilisateur($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Utilisateur($donnee));
        }
        return $this->getListUtilisateurs();
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
    public function getListUtilisateurs()
    {
        return $this->_listUtilisateurs;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListUtilisateurs($listUtilisateurs)
    {
        $this->_listUtilisateurs = $listUtilisateurs;
    }

    /**
     * @return mixed
     */
    public function getNbreUtilisateur()
    {
        return $this->_nbreUtilisateur;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreUtilisateur($nbreUtilisateur)
    {
        $this->_nbreUtilisateur = $nbreUtilisateur;
    }





}
