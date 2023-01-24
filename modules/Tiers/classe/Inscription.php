<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class Classe
{
// IDINSCRIPTION DATEINSCRIPT FRAIS_INSCRIPTION MONTANT ACCOMPTE_VERSE STATUT IDNIVEAU IDINDIVIDU IDETABLISSEMENT
// IDANNEESSCOLAIRE IDSERIE DERNIER_ETAB VALIDETUDE FRAIS_DOSSIER FRAIS_EXAMEN UNIFORME VACCINATION ASSURANCE
// FRAIS_SOUTENANCE MONTANT_DOSSIER MONTANT_EXAMEN MONTANT_UNIFORME MONTANT_VACCINATION MONTANT_ASSURANCE MONTANT_SOUTENANCE
// RESULTAT_ANNUEL ACCORD_MENSUELITE
    private $IDINSCRIPTION;
    private $DATEINSCRIPT;
    private $FRAIS_INSCRIPTION;
    private $MONTANT;
    private $ACCOMPTE_VERSE;
    private $STATUT;
    private $IDNIVEAU;
    private $IDINDIVIDU;
    private $IDETABLISSEMENT;
    private $IDANNEESSCOLAIRE;
    private $IDSERIE;
    private $DERNIER_ETAB;
    private $VALIDETUDE;
    private $FRAIS_DOSSIER;
    private $FRAIS_EXAMEN;
    private $UNIFORME;
    private $VACCINATION;
    private $ASSURANCE;
    private $FRAIS_SOUTENANCE;
    private $MONTANT_DOSSIER;
    private $MONTANT_EXAMEN;
    private $MONTANT_UNIFORME;
    private $MONTANT_VACCINATION;
    private $MONTANT_ASSURANCE;
    private $MONTANT_SOUTENANCE;
    private $RESULTAT_ANNUEL;
    private $ACCORD_MENSUELITE;




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
    public function getMONTANTDOSSIER()
    {
        return $this->MONTANT_DOSSIER;
    }

    /**
     * @param mixed $MONTANT_DOSSIER
     */
    public function setMONTANTDOSSIER($MONTANT_DOSSIER)
    {
        $this->MONTANT_DOSSIER = $MONTANT_DOSSIER;
    }

    /**
     * @return mixed
     */
    public function getACCOMPTEVERSE()
    {
        return $this->ACCOMPTE_VERSE;
    }

    /**
     * @param mixed $ACCOMPTE_VERSE
     */
    public function setACCOMPTEVERSE($ACCOMPTE_VERSE)
    {
        $this->ACCOMPTE_VERSE = $ACCOMPTE_VERSE;
    }

    /**
     * @return mixed
     */
    public function getACCORDMENSUELITE()
    {
        return $this->ACCORD_MENSUELITE;
    }

    /**
     * @param mixed $ACCORD_MENSUELITE
     */
    public function setACCORDMENSUELITE($ACCORD_MENSUELITE)
    {
        $this->ACCORD_MENSUELITE = $ACCORD_MENSUELITE;
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
    public function getDATEINSCRIPT()
    {
        return $this->DATEINSCRIPT;
    }

    /**
     * @param mixed $DATEINSCRIPT
     */
    public function setDATEINSCRIPT($DATEINSCRIPT)
    {
        $this->DATEINSCRIPT = $DATEINSCRIPT;
    }

    /**
     * @return mixed
     */
    public function getDERNIERETAB()
    {
        return $this->DERNIER_ETAB;
    }

    /**
     * @param mixed $DERNIER_ETAB
     */
    public function setDERNIERETAB($DERNIER_ETAB)
    {
        $this->DERNIER_ETAB = $DERNIER_ETAB;
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
    public function getIDANNEESSCOLAIRE()
    {
        return $this->IDANNEESSCOLAIRE;
    }

    /**
     * @param mixed $IDANNEESSCOLAIRE
     */
    public function setIDANNEESSCOLAIRE($IDANNEESSCOLAIRE)
    {
        $this->IDANNEESSCOLAIRE = $IDANNEESSCOLAIRE;
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
    public function getIDINSCRIPTION()
    {
        return $this->IDINSCRIPTION;
    }

    /**
     * @param mixed $IDINSCRIPTION
     */
    public function setIDINSCRIPTION($IDINSCRIPTION)
    {
        $this->IDINSCRIPTION = $IDINSCRIPTION;
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
    public function getMONTANT()
    {
        return $this->MONTANT;
    }

    /**
     * @param mixed $MONTANT
     */
    public function setMONTANT($MONTANT)
    {
        $this->MONTANT = $MONTANT;
    }

    /**
     * @return mixed
     */
    public function getMONTANTASSURANCE()
    {
        return $this->MONTANT_ASSURANCE;
    }

    /**
     * @param mixed $MONTANT_ASSURANCE
     */
    public function setMONTANTASSURANCE($MONTANT_ASSURANCE)
    {
        $this->MONTANT_ASSURANCE = $MONTANT_ASSURANCE;
    }

    /**
     * @return mixed
     */
    public function getMONTANTEXAMEN()
    {
        return $this->MONTANT_EXAMEN;
    }

    /**
     * @param mixed $MONTANT_EXAMEN
     */
    public function setMONTANTEXAMEN($MONTANT_EXAMEN)
    {
        $this->MONTANT_EXAMEN = $MONTANT_EXAMEN;
    }

    /**
     * @return mixed
     */
    public function getMONTANTSOUTENANCE()
    {
        return $this->MONTANT_SOUTENANCE;
    }

    /**
     * @param mixed $MONTANT_SOUTENANCE
     */
    public function setMONTANTSOUTENANCE($MONTANT_SOUTENANCE)
    {
        $this->MONTANT_SOUTENANCE = $MONTANT_SOUTENANCE;
    }

    /**
     * @return mixed
     */
    public function getMONTANTUNIFORME()
    {
        return $this->MONTANT_UNIFORME;
    }

    /**
     * @param mixed $MONTANT_UNIFORME
     */
    public function setMONTANTUNIFORME($MONTANT_UNIFORME)
    {
        $this->MONTANT_UNIFORME = $MONTANT_UNIFORME;
    }

    /**
     * @return mixed
     */
    public function getMONTANTVACCINATION()
    {
        return $this->MONTANT_VACCINATION;
    }

    /**
     * @param mixed $MONTANT_VACCINATION
     */
    public function setMONTANTVACCINATION($MONTANT_VACCINATION)
    {
        $this->MONTANT_VACCINATION = $MONTANT_VACCINATION;
    }

    /**
     * @return mixed
     */
    public function getRESULTATANNUEL()
    {
        return $this->RESULTAT_ANNUEL;
    }

    /**
     * @param mixed $RESULTAT_ANNUEL
     */
    public function setRESULTATANNUEL($RESULTAT_ANNUEL)
    {
        $this->RESULTAT_ANNUEL = $RESULTAT_ANNUEL;
    }

    /**
     * @return mixed
     */
    public function getSTATUT()
    {
        return $this->STATUT;
    }

    /**
     * @param mixed $STATUT
     */
    public function setSTATUT($STATUT)
    {
        $this->STATUT = $STATUT;
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
    public function getVALIDETUDE()
    {
        return $this->VALIDETUDE;
    }

    /**
     * @param mixed $VALIDETUDE
     */
    public function setVALIDETUDE($VALIDETUDE)
    {
        $this->VALIDETUDE = $VALIDETUDE;
    }





}
