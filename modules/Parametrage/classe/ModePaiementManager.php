<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Modepaiement.php');
require_once("../manager.php");

class ModepaiementManager extends manager{
    protected $_listMODE_PAIEMENTx; // array
    protected $_nbreMODE_PAIEMENT;

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
        $this->_listMODE_PAIEMENTx[] = $obj;
        $this->_nbreMODE_PAIEMENT++;

    }

    // liste de tous les abonnements
    public function getMODE_PAIEMENTx($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){

            $this->add(new MODE_PAIEMENT($donnee));
        }
        return $this->getListMODE_PAIEMENTx();

    }

    //liste d'un abonnement
    public function getMODE_PAIEMENT($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new MODE_PAIEMENT($donnee));
        }
        return $this->getListMODE_PAIEMENTx();
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
    public function getListMODE_PAIEMENTx()
    {
        return $this->_listMODE_PAIEMENTx;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListMODE_PAIEMENTx($listMODE_PAIEMENTx)
    {
        $this->_listMODE_PAIEMENTx = $listMODE_PAIEMENTx;
    }

    /**
     * @return mixed
     */
    public function getNbreMODE_PAIEMENT()
    {
        return $this->_nbreMODE_PAIEMENT;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreMODE_PAIEMENT($nbreMODE_PAIEMENT)
    {
        $this->_nbreMODE_PAIEMENT = $nbreMODE_PAIEMENT;
    }





}
