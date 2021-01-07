<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class FraisInscription
{
    //ID_NIV_SER IDSERIE IDNIVEAU MT_MENSUALITE FRAIS_INSCRIPTION FRAIS_DOSSIER VACCINATION UNIFORME ASSURANCE FRAIS_EXAMEN FRAIS_SOUTENANCE dure montant_total IDETABLISSEMENT
    private $ID_NIV_SER;
    private $IDSERIE;
    private $IDNIVEAU;
    private $MT_MENSUALITE;
    private $FRAIS_INSCRIPTION;
    private $FRAIS_DOSSIER;

    private $VACCINATION;
    private $UNIFORME;
    private $ASSURANCE;
    private $FRAIS_EXAMEN;
    private $FRAIS_SOUTENANCE;
    private $dure;
    private $montant_total;
    private $IDETABLISSEMENT;



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
    public function getIDNIVSER()
    {
        return $this->ID_NIV_SER;
    }

    /**
     * @param mixed $ID_NIV_SER
     */
    public function setIDNIVSER($ID_NIV_SER)
    {
        $this->ID_NIV_SER = $ID_NIV_SER;
    }

    /**
     * @return mixed
     */
    public function getIDSERIE()
    {
        return $this->IDSERIE;
    }

    /**
     * @param mixed $IDSERIE
     */
    public function setIDSERIE($IDSERIE)
    {
        $this->IDSERIE = $IDSERIE;
    }

    /**
     * @return mixed
     */
    public function getIDNIVEAU()
    {
        return $this->IDNIVEAU;
    }

    /**
     * @param mixed $IDNIVEAU
     */
    public function setIDNIVEAU($IDNIVEAU)
    {
        $this->IDNIVEAU = $IDNIVEAU;
    }

    /**
     * @return mixed
     */
    public function getMTMENSUALITE()
    {
        return $this->MT_MENSUALITE;
    }

    /**
     * @param mixed $MT_MENSUALITE
     */
    public function setMTMENSUALITE($MT_MENSUALITE)
    {
        $this->MT_MENSUALITE = $MT_MENSUALITE;
    }

    /**
     * @return mixed
     */
    public function getFRAISINSCRIPTION()
    {
        return $this->FRAIS_INSCRIPTION;
    }

    /**
     * @param mixed $FRAIS_INSCRIPTION
     */
    public function setFRAISINSCRIPTION($FRAIS_INSCRIPTION)
    {
        $this->FRAIS_INSCRIPTION = $FRAIS_INSCRIPTION;
    }

    /**
     * @return mixed
     */
    public function getFRAISDOSSIER()
    {
        return $this->FRAIS_DOSSIER;
    }

    /**
     * @param mixed $FRAIS_DOSSIER
     */
    public function setFRAISDOSSIER($FRAIS_DOSSIER)
    {
        $this->FRAIS_DOSSIER = $FRAIS_DOSSIER;
    }

    /**
     * @return mixed
     */
    public function getVACCINATION()
    {
        return $this->VACCINATION;
    }

    /**
     * @param mixed $VACCINATION
     */
    public function setVACCINATION($VACCINATION)
    {
        $this->VACCINATION = $VACCINATION;
    }

    /**
     * @return mixed
     */
    public function getUNIFORME()
    {
        return $this->UNIFORME;
    }

    /**
     * @param mixed $UNIFORME
     */
    public function setUNIFORME($UNIFORME)
    {
        $this->UNIFORME = $UNIFORME;
    }

    /**
     * @return mixed
     */
    public function getASSURANCE()
    {
        return $this->ASSURANCE;
    }

    /**
     * @param mixed $ASSURANCE
     */
    public function setASSURANCE($ASSURANCE)
    {
        $this->ASSURANCE = $ASSURANCE;
    }

    /**
     * @return mixed
     */
    public function getFRAISEXAMEN()
    {
        return $this->FRAIS_EXAMEN;
    }

    /**
     * @param mixed $FRAIS_EXAMEN
     */
    public function setFRAISEXAMEN($FRAIS_EXAMEN)
    {
        $this->FRAIS_EXAMEN = $FRAIS_EXAMEN;
    }

    /**
     * @return mixed
     */
    public function getFRAISSOUTENANCE()
    {
        return $this->FRAIS_SOUTENANCE;
    }

    /**
     * @param mixed $FRAIS_SOUTENANCE
     */
    public function setFRAISSOUTENANCE($FRAIS_SOUTENANCE)
    {
        $this->FRAIS_SOUTENANCE = $FRAIS_SOUTENANCE;
    }

    /**
     * @return mixed
     */
    public function getDure()
    {
        return $this->dure;
    }

    /**
     * @param mixed $dure
     */
    public function setDure($dure)
    {
        $this->dure = $dure;
    }

    /**
     * @return mixed
     */
    public function getMontantTotal()
    {
        return $this->montant_total;
    }

    /**
     * @param mixed $montant_total
     */
    public function setMontantTotal($montant_total)
    {
        $this->montant_total = $montant_total;
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


}