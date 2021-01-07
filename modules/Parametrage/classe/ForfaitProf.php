<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class ForfaitProf
{
    //ROWID LIBELLE IDETABLISSEMENT
    private $ROWID;
    private $LIBELLE;
    private $NBRE_JOUR;
    private $MONTANT;
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
    public function getNBRE_JOUR()
    {
        return $this->NBRE_JOUR;
    }

    /**
     * @param mixed $NBRE_JOUR
     */
    public function setNBRE_JOUR($NBRE_JOUR)
    {
        $this->NBRE_JOUR = $NBRE_JOUR;
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




}