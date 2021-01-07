<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Banque
{
    private $ROWID;
    private $LABEL;
    private $TEL;
    private $ADRESSE;
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
    public function getLABEL()
    {
        return $this->LABEL;
    }

    /**
     * @param mixed $TYPE_SALLE
     */
    public function setTYPE_SALLE($LABEL)
    {
        $this->LABEL = $LABEL;
    }

    /**
     * @return mixed
     */
    public function getTEL()
    {
        return $this->TEL;
    }

    /**
     * @param mixed $TEL
     */
    public function setTEL($TEL)
    {
        $this->TEL = $TEL;
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