<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Sanction
{
    //IDSANCTION DATE MOTIF DATEDEBUT DATEFIN IDINDIVIDU IDETABLISSEMENT ID_AUTHORITE
    private $IDSANCTION;
    private $DATE;
    private $MOTIF;
    private $DATEDEBUT;
    private $DATEFIN;
    private $IDINDIVIDU;
    private $IDETABLISSEMENT;
    private $ID_AUTHORITE;




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
    public function getDATEDEBUT()
    {
        return $this->DATEDEBUT;
    }

    /**
     * @param mixed $DATEDEBUT
     */
    public function setDATEDEBUT($DATEDEBUT)
    {
        $this->DATEDEBUT = $DATEDEBUT;
    }

    /**
     * @return mixed
     */
    public function getDATEFIN()
    {
        return $this->DATEFIN;
    }

    /**
     * @param mixed $DATEFIN
     */
    public function setDATEFIN($DATEFIN)
    {
        $this->DATEFIN = $DATEFIN;
    }

    /**
     * @return mixed
     */
    public function getIDAUTHORITE()
    {
        return $this->ID_AUTHORITE;
    }

    /**
     * @param mixed $ID_AUTHORITE
     */
    public function setIDAUTHORITE($ID_AUTHORITE)
    {
        $this->ID_AUTHORITE = $ID_AUTHORITE;
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
    public function getIDSANCTION()
    {
        return $this->IDSANCTION;
    }

    /**
     * @param mixed $IDSANCTION
     */
    public function setIDSANCTION($IDSANCTION)
    {
        $this->IDSANCTION = $IDSANCTION;
    }

    /**
     * @return mixed
     */
    public function getMOTIF()
    {
        return $this->MOTIF;
    }

    /**
     * @param mixed $MOTIF
     */
    public function setMOTIF($MOTIF)
    {
        $this->MOTIF = $MOTIF;
    }





}