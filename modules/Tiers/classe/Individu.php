<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Classe
{
    //<!-- IDINDIVIDU MATRICULE NOM PRENOMS DATNAISSANCE ADRES TELMOBILE TELDOM COURRIEL LOGIN MP CODE BIOGRAPHIE PHOTO_FACE IDETABLISSEMENT IDTYPEINDIVIDU SEXE IDPERE IDMERE IDTUTEUR
// ANNEEBAC NATIONNALITE SIT_MATRIMONIAL NUMID -->
    private $IDINDIVIDU;
    private $MATRICULE;
    private $NOM;
    private $PRENOMS;
    private $DATNAISSANCE;

    private $ADRES;
    private $TELMOBILE;
    private $TELDOM;
    private $COURRIEL;
    private $LOGIN;

    private $MP;
    private $CODE;
    private $BIOGRAPHIE;
    private $PHOTO_FACE;
    private $IDETABLISSEMENT;

    private $IDTYPEINDIVIDU;
    private $SEXE;
    private $IDPERE;
    private $IDMERE;
    private $IDTUTEUR;

    private $ANNEEBAC;
    private $NATIONNALITE;
    private $SIT_MATRIMONIAL;
    private $NUMID;




    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }


    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getIDINDIVIDU()
    {
        return $this->IDINDIVIDU;
    }

    /**
     * @param mixed $IDINDIVIDU
     */
    public function setIDINDIVIDU($IDINDIVIDU)
    {
        $this->IDINDIVIDU = $IDINDIVIDU;
    }

    /**
     * @return mixed
     */
    public function getMATRICULE()
    {
        return $this->MATRICULE;
    }

    /**
     * @param mixed $MATRICULE
     */
    public function setMATRICULE($MATRICULE)
    {
        $this->MATRICULE = $MATRICULE;
    }

    /**
     * @return mixed
     */
    public function getNOM()
    {
        return $this->NOM;
    }

    /**
     * @param mixed $NOM
     */
    public function setNOM($NOM)
    {
        $this->NOM = $NOM;
    }

    /**
     * @return mixed
     */
    public function getPRENOMS()
    {
        return $this->PRENOMS;
    }

    /**
     * @param mixed $PRENOMS
     */
    public function setPRENOMS($PRENOMS)
    {
        $this->PRENOMS = $PRENOMS;
    }

    /**
     * @return mixed
     */
    public function getDATNAISSANCE()
    {
        return $this->DATNAISSANCE;
    }

    /**
     * @param mixed $DATNAISSANCE
     */
    public function setDATNAISSANCE($DATNAISSANCE)
    {
        $this->DATNAISSANCE = $DATNAISSANCE;
    }

    /**
     * @return mixed
     */
    public function getADRES()
    {
        return $this->ADRES;
    }

    /**
     * @param mixed $ADRES
     */
    public function setADRES($ADRES)
    {
        $this->ADRES = $ADRES;
    }

    /**
     * @return mixed
     */
    public function getTELMOBILE()
    {
        return $this->TELMOBILE;
    }

    /**
     * @param mixed $TELMOBILE
     */
    public function setTELMOBILE($TELMOBILE)
    {
        $this->TELMOBILE = $TELMOBILE;
    }

    /**
     * @return mixed
     */
    public function getTELDOM()
    {
        return $this->TELDOM;
    }

    /**
     * @param mixed $TELDOM
     */
    public function setTELDOM($TELDOM)
    {
        $this->TELDOM = $TELDOM;
    }

    /**
     * @return mixed
     */
    public function getCOURRIEL()
    {
        return $this->COURRIEL;
    }

    /**
     * @param mixed $COURRIEL
     */
    public function setCOURRIEL($COURRIEL)
    {
        $this->COURRIEL = $COURRIEL;
    }

    /**
     * @return mixed
     */
    public function getLOGIN()
    {
        return $this->LOGIN;
    }

    /**
     * @param mixed $LOGIN
     */
    public function setLOGIN($LOGIN)
    {
        $this->LOGIN = $LOGIN;
    }

    /**
     * @return mixed
     */
    public function getMP()
    {
        return $this->MP;
    }

    /**
     * @param mixed $MP
     */
    public function setMP($MP)
    {
        $this->MP = $MP;
    }

    /**
     * @return mixed
     */
    public function getCODE()
    {
        return $this->CODE;
    }

    /**
     * @param mixed $CODE
     */
    public function setCODE($CODE)
    {
        $this->CODE = $CODE;
    }

    /**
     * @return mixed
     */
    public function getPHOTOFACE()
    {
        return $this->PHOTO_FACE;
    }

    /**
     * @param mixed $PHOTO_FACE
     */
    public function setPHOTOFACE($PHOTO_FACE)
    {
        $this->PHOTO_FACE = $PHOTO_FACE;
    }

    /**
     * @return mixed
     */
    public function getBIOGRAPHIE()
    {
        return $this->BIOGRAPHIE;
    }

    /**
     * @param mixed $BIOGRAPHIE
     */
    public function setBIOGRAPHIE($BIOGRAPHIE)
    {
        $this->BIOGRAPHIE = $BIOGRAPHIE;
    }

    /**
     * @return mixed
     */
    public function getIDETABLISSEMENT()
    {
        return $this->IDETABLISSEMENT;
    }

    /**
     * @param mixed $IDETABLISSEMENT
     */
    public function setIDETABLISSEMENT($IDETABLISSEMENT)
    {
        $this->IDETABLISSEMENT = $IDETABLISSEMENT;
    }

    /**
     * @return mixed
     */
    public function getIDTYPEINDIVIDU()
    {
        return $this->IDTYPEINDIVIDU;
    }

    /**
     * @param mixed $IDTYPEINDIVIDU
     */
    public function setIDTYPEINDIVIDU($IDTYPEINDIVIDU)
    {
        $this->IDTYPEINDIVIDU = $IDTYPEINDIVIDU;
    }

    /**
     * @return mixed
     */
    public function getSEXE()
    {
        return $this->SEXE;
    }

    /**
     * @param mixed $SEXE
     */
    public function setSEXE($SEXE)
    {
        $this->SEXE = $SEXE;
    }

    /**
     * @return mixed
     */
    public function getIDPERE()
    {
        return $this->IDPERE;
    }

    /**
     * @param mixed $IDPERE
     */
    public function setIDPERE($IDPERE)
    {
        $this->IDPERE = $IDPERE;
    }

    /**
     * @return mixed
     */
    public function getIDMERE()
    {
        return $this->IDMERE;
    }

    /**
     * @param mixed $IDMERE
     */
    public function setIDMERE($IDMERE)
    {
        $this->IDMERE = $IDMERE;
    }

    /**
     * @return mixed
     */
    public function getIDTUTEUR()
    {
        return $this->IDTUTEUR;
    }

    /**
     * @param mixed $IDTUTEUR
     */
    public function setIDTUTEUR($IDTUTEUR)
    {
        $this->IDTUTEUR = $IDTUTEUR;
    }

    /**
     * @return mixed
     */
    public function getANNEEBAC()
    {
        return $this->ANNEEBAC;
    }

    /**
     * @param mixed $ANNEEBAC
     */
    public function setANNEEBAC($ANNEEBAC)
    {
        $this->ANNEEBAC = $ANNEEBAC;
    }

    /**
     * @return mixed
     */
    public function getNATIONNALITE()
    {
        return $this->NATIONNALITE;
    }

    /**
     * @param mixed $NATIONNALITE
     */
    public function setNATIONNALITE($NATIONNALITE)
    {
        $this->NATIONNALITE = $NATIONNALITE;
    }

    /**
     * @return mixed
     */
    public function getSITMATRIMONIAL()
    {
        return $this->SIT_MATRIMONIAL;
    }

    /**
     * @param mixed $SIT_MATRIMONIAL
     */
    public function setSITMATRIMONIAL($SIT_MATRIMONIAL)
    {
        $this->SIT_MATRIMONIAL = $SIT_MATRIMONIAL;
    }

    /**
     * @return mixed
     */
    public function getNUMID()
    {
        return $this->NUMID;
    }

    /**
     * @param mixed $NUMID
     */
    public function setNUMID($NUMID)
    {
        $this->NUMID = $NUMID;
    }



}