<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class Niv
{
    private $ID;
    private $LIBELLE;
    private $IDNIVEAU;
    //private $EXAMEN;
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
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
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
