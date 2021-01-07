<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Uniforme
{
    private $ROWID;
    private $LIBELLE;
    private $IDNIVEAU;
    private $MONTANT;


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
        $this->ID = $ROWID;
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

    public function getEXAMEN()
    {
        return $this->EXAMEN;
    }*/

    /**
     * @param mixed $EXAMEN

    public function setEXAMEN($EXAMEN)
    {
        $this->EXAMEN = $EXAMEN;
    }*/


}