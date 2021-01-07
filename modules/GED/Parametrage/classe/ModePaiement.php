<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class ModePaiement
{
    //ROWID LIBELLE IDETABLISSEMENT
    private $ROWID;
    private $LIBELLE;
    private $IDETABLISSEMENT;
    private $NBRE_MOIS;


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
 public function getNBRE_MOIS()
    {
        return $this->NBRE_MOIS;
    }

    /**
     * @param mixed $LIBELLE
     */
    public function setNBRE_MOIS($NBRE_MOIS)
    {
        $this->LIBELLE = $NBRE_MOIS;
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