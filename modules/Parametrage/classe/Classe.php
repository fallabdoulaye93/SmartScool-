<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Classe
{
    //IDCLASSROOM LIBELLE IDNIVEAU IDETABLISSEMENT IDSERIE
    private $IDCLASSROOM;
    private $LIBELLE;
    private $IDNIVEAU;
    private $IDETABLISSEMENT;
    private $IDSERIE;
    private $IDNIV;



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
    public function getIDCLASSROOM()
    {
        return $this->IDCLASSROOM;
    }

    /**
     * @param mixed $IDCLASSROOM
     */
    public function setIDCLASSROOM($IDCLASSROOM)
    {
        $this->IDCLASSROOM = $IDCLASSROOM;
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
    public function getIDNIV()
    {
        return $this->IDNIV;
    }

    /**
     * @param mixed $IDNIV
     */
    public function setIDNIV($IDNIV)
    {
        $this->IDNIV = $IDNIV;
    }


}