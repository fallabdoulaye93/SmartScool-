<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Etablissement
{
    //IDETABLISSEMENT NOMETABLISSEMENT_ SIGLE ADRESSE TELEPHONE REGLEMENTINTERIEUR VILLE PAYS DEVISE FAX MAIL SITEWEB LOGO CAPITAL FORM_JURIDIQUE RC NINEA NUM_TV PREFIXE
    private $IDETABLISSEMENT;
    private $NOMETABLISSEMENT_;
    private $SIGLE;
    private $ADRESSE;
    private $TELEPHONE;
    private $REGLEMENTINTERIEUR;

    private $VILLE;
    private $PAYS;
    private $DEVISE;
    private $FAX;
    private $MAIL;
    private $SITEWEB;

    private $LOGO;
    private $CAPITAL;
    private $FORM_JURIDIQUE;
    private $RC;
    private $NINEA;
    private $NUM_TV;
    private $PREFIXE;
    private $TABLEAU_HONNEUR;


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
    public function getNOMETABLISSEMENT()
    {
        return $this->NOMETABLISSEMENT_;
    }

    /**
     * @param mixed $NOMETABLISSEMENT_
     */
    public function setNOMETABLISSEMENT($NOMETABLISSEMENT_)
    {
        $this->NOMETABLISSEMENT_ = $NOMETABLISSEMENT_;
    }

    /**
     * @return mixed
     */
    public function getSIGLE()
    {
        return $this->SIGLE;
    }

    /**
     * @param mixed $SIGLE
     */
    public function setSIGLE($SIGLE)
    {
        $this->SIGLE = $SIGLE;
    }

    /**
     * @return mixed
     */
    public function getADRESSE()
    {
        return $this->ADRESSE;
    }

    /**
     * @param mixed $ADRESSE
     */
    public function setADRESSE($ADRESSE)
    {
        $this->ADRESSE = $ADRESSE;
    }

    /**
     * @return mixed
     */
    public function getTELEPHONE()
    {
        return $this->TELEPHONE;
    }

    /**
     * @param mixed $TELEPHONE
     */
    public function setTELEPHONE($TELEPHONE)
    {
        $this->TELEPHONE = $TELEPHONE;
    }

    /**
     * @return mixed
     */
    public function getREGLEMENTINTERIEUR()
    {
        return $this->REGLEMENTINTERIEUR;
    }

    /**
     * @param mixed $REGLEMENTINTERIEUR
     */
    public function setREGLEMENTINTERIEUR($REGLEMENTINTERIEUR)
    {
        $this->REGLEMENTINTERIEUR = $REGLEMENTINTERIEUR;
    }

    /**
     * @return mixed
     */
    public function getVILLE()
    {
        return $this->VILLE;
    }

    /**
     * @param mixed $VILLE
     */
    public function setVILLE($VILLE)
    {
        $this->VILLE = $VILLE;
    }

    /**
     * @return mixed
     */
    public function getDEVISE()
    {
        return $this->DEVISE;
    }

    /**
     * @param mixed $DEVISE
     */
    public function setDEVISE($DEVISE)
    {
        $this->DEVISE = $DEVISE;
    }

    /**
     * @return mixed
     */
    public function getPAYS()
    {
        return $this->PAYS;
    }

    /**
     * @param mixed $PAYS
     */
    public function setPAYS($PAYS)
    {
        $this->PAYS = $PAYS;
    }

    /**
     * @return mixed
     */
    public function getFAX()
    {
        return $this->FAX;
    }

    /**
     * @param mixed $FAX
     */
    public function setFAX($FAX)
    {
        $this->FAX = $FAX;
    }

    /**
     * @return mixed
     */
    public function getMAIL()
    {
        return $this->MAIL;
    }

    /**
     * @param mixed $MAIL
     */
    public function setMAIL($MAIL)
    {
        $this->MAIL = $MAIL;
    }

    /**
     * @return mixed
     */
    public function getSITEWEB()
    {
        return $this->SITEWEB;
    }

    /**
     * @param mixed $SITEWEB
     */
    public function setSITEWEB($SITEWEB)
    {
        $this->SITEWEB = $SITEWEB;
    }

    /**
     * @return mixed
     */
    public function getLOGO()
    {
        return $this->LOGO;
    }

    /**
     * @param mixed $LOGO
     */
    public function setLOGO($LOGO)
    {
        $this->LOGO = $LOGO;
    }

    /**
     * @return mixed
     */
    public function getCAPITAL()
    {
        return $this->CAPITAL;
    }

    /**
     * @param mixed $CAPITAL
     */
    public function setCAPITAL($CAPITAL)
    {
        $this->CAPITAL = $CAPITAL;
    }

    /**
     * @return mixed
     */
    public function getFORMJURIDIQUE()
    {
        return $this->FORM_JURIDIQUE;
    }

    /**
     * @param mixed $FORM_JURIDIQUE
     */
    public function setFORMJURIDIQUE($FORM_JURIDIQUE)
    {
        $this->FORM_JURIDIQUE = $FORM_JURIDIQUE;
    }

    /**
     * @return mixed
     */
    public function getRC()
    {
        return $this->RC;
    }

    /**
     * @param mixed $RC
     */
    public function setRC($RC)
    {
        $this->RC = $RC;
    }

    /**
     * @return mixed
     */
    public function getNINEA()
    {
        return $this->NINEA;
    }

    /**
     * @param mixed $NINEA
     */
    public function setNINEA($NINEA)
    {
        $this->NINEA = $NINEA;
    }

    /**
     * @return mixed
     */
    public function getNUMTV()
    {
        return $this->NUM_TV;
    }

    /**
     * @param mixed $NUM_TV
     */
    public function setNUMTV($NUM_TV)
    {
        $this->NUM_TV = $NUM_TV;
    }

    /**
     * @return mixed
     */
    public function getPREFIXE()
    {
        return $this->PREFIXE;
    }

    /**
     * @param mixed $PREFIXE
     */
    public function setPREFIXE($PREFIXE)
    {
        $this->PREFIXE = $PREFIXE;
    }

    /**
     * @return mixed
     */
    public function getTABLEAUHONNEUR()
    {
        return $this->TABLEAUHONNEUR;
    }

    /**
     * @param mixed $TABLEAUHONNEUR
     */
    public function setTABLEAUHONNEUR($TABLEAUHONNEUR)
    {
        $this->TABLEAUHONNEUR = $TABLEAUHONNEUR;
    }




}