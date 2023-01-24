<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Profile.php');
require_once("../manager.php");

class ProfileManager extends manager{
    protected $_listProfiles; // array
    protected $_nbreProfile;

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
        $this->_listProfiles[] = $obj;
        $this->_nbreProfile++;

    }

    // liste de tous les abonnements
    public function getProfiles($fields=null)
    {
        $donnees=parent::lister($fields);
        foreach($donnees as $donnee){
            $this->add(new Profile($donnee));
        }
        return $this->getListProfiles();

    }

    //liste d'un abonnement
    public function getProfile($idChamp,$idValue)
    {
        $donnees=parent::listerAvecId('',$idChamp,$idValue);
        foreach($donnees as $donnee){

            $this->add(new Profile($donnee));
        }
        return $this->getListProfiles();
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
    public function getListProfiles()
    {
        return $this->_listProfiles;
    }

    /**
     * @param mixed $listAbonnements
     */
    public function setListProfiles($listProfiles)
    {
        $this->_listProfiles = $listProfiles;
    }

    /**
     * @return mixed
     */
    public function getNbreProfile()
    {
        return $this->_nbreProfile;
    }

    /**
     * @param mixed $nbreAbonnement
     */
    public function setNbreProfile($nbreProfile)
    {
        $this->_nbreProfile = $nbreProfile;
    }





}
