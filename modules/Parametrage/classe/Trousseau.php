<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class Trousseau
{
    //ROWID LIBELLE IDETABLISSEMENT
    private $ROWID;
    private $LIBELLE;
    private $MONTANT;
    private $CYCLE;
    private $SEXE;
    private $FK_NIVEAU;
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
    public function getROWID()
    {
        return $this->ROWID;
    }

    /**
     * @param mixed $ROWID
     */
    public function setROWID($ROWID)
    {
        $this->ROWID = $ROWID;
    }

    /**
     * @return mixed
     */
    public function getLIBELLE()
    {
        return $this->LIBELLE;
    }

    /**
     * @param mixed $LIBELLE
     */
    public function setLIBELLE($LIBELLE)
    {
        $this->LIBELLE = $LIBELLE;
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
    public function getCYCLE()
    {
        return $this->CYCLE;
    }

    /**
     * @param mixed $MONTANT
     */
    public function setCYCLE($CYCLE)
    {
        $this->CYCLE = $CYCLE;
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
    public function getFK_NIVEAU()
    {
        return $this->FK_NIVEAU;
    }

    /**
     * @param mixed $FK_NIVEAU
     */
    public function setFK_NIVEAU($FK_NIVEAU)
    {
        $this->FK_NIVEAU = $FK_NIVEAU;
    }




}
