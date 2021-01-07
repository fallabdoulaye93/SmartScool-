<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Equipement
{
    // IDEQUIPEMENT FACTURE MONTANT DATE NOMEQUIPEMENT IDCATEGEQUIP IDETABLISSEMENT QTE ANNEESSCOLAIRE QTE_RESTANTE
    private $IDEQUIPEMENT;
    private $FACTURE;
    private $MONTANT;
    private $DATE;
    private $NOMEQUIPEMENT;
	private $IDCATEGEQUIP;
    private $IDETABLISSEMENT;
    private $QTE;
    private $ANNEESSCOLAIRE;
    private $QTE_RESTANTE;



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
    public function getIDEQUIPEMENT()
    {
        return $this->IDEQUIPEMENT;
    }

    /**
     * @param mixed $IDEQUIPEMENT
     */
    public function setIDEQUIPEMENT($IDEQUIPEMENT)
    {
        $this->IDEQUIPEMENT = $IDEQUIPEMENT;
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
    public function getFACTURE()
    {
        return $this->FACTURE;
    }

    /**
     * @param mixed $FACTURE
     */
    public function setFACTURE($FACTURE)
    {
        $this->FACTURE = $FACTURE;
    }

    /**
     * @return mixed
     */
    public function getDATE()
    {
        return $this->DATE;
    }

    /**
     * @param mixed $DATE
     */
    public function setDATE($DATE)
    {
        $this->DATE = $DATE;
    }

    /**
     * @return mixed
     */
    public function getNOMEQUIPEMENT()
    {
        return $this->NOMEQUIPEMENT;
    }

    /**
     * @param mixed $NOMEQUIPEMENT
     */
    public function setNOMEQUIPEMENT($NOMEQUIPEMENT)
    {
        $this->NOMEQUIPEMENT = $NOMEQUIPEMENT;
    }

    /**
     * @return mixed
     */
    public function getIDCATEGEQUIP()
    {
        return $this->IDCATEGEQUIP;
    }

    /**
     * @param mixed $IDCATEGEQUIP
     */
    public function setIDCATEGEQUIP($IDCATEGEQUIP)
    {
        $this->IDCATEGEQUIP = $IDCATEGEQUIP;
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
    public function getQTE()
    {
        return $this->QTE;
    }

    /**
     * @param mixed $QTE
     */
    public function setQTE($QTE)
    {
        $this->QTE = $QTE;
    }

    /**
     * @return mixed
     */
    public function getANNEESSCOLAIRE()
    {
        return $this->ANNEESSCOLAIRE;
    }

    /**
     * @param mixed $ANNEESSCOLAIRE
     */
    public function setANNEESSCOLAIRE($ANNEESSCOLAIRE)
    {
        $this->ANNEESSCOLAIRE = $ANNEESSCOLAIRE;
    }

    /**
     * @return mixed
     */
    public function getQTERESTANTE()
    {
        return $this->QTE_RESTANTE;
    }

    /**
     * @param mixed $QTE_RESTANTE
     */
    public function setQTERESTANTE($QTE_RESTANTE)
    {
        $this->QTE_RESTANTE = $QTE_RESTANTE;
    }



    
}