<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class Salle
{
    //IDSALL_DE_CLASSE NOM_SALLE IDTYPE_SALLE IDETABLISSEMENT NBR_PLACES
    private $IDSALL_DE_CLASSE;
    private $NOM_SALLE;
    private $IDTYPE_SALLE;
    private $IDETABLISSEMENT;
    private $NBR_PLACES;



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
    public function getIDSALLDECLASSE()
    {
        return $this->IDSALL_DE_CLASSE;
    }

    /**
     * @param mixed $IDSALL_DE_CLASSE
     */
    public function setIDSALLDECLASSE($IDSALL_DE_CLASSE)
    {
        $this->IDSALL_DE_CLASSE = $IDSALL_DE_CLASSE;
    }

    /**
     * @return mixed
     */
    public function getNOMSALLE()
    {
        return $this->NOM_SALLE;
    }

    /**
     * @param mixed $NOM_SALLE
     */
    public function setNOMSALLE($NOM_SALLE)
    {
        $this->NOM_SALLE = $NOM_SALLE;
    }

    /**
     * @return mixed
     */
    public function getIDTYPESALLE()
    {
        return $this->IDTYPE_SALLE;
    }

    /**
     * @param mixed $IDTYPE_SALLE
     */
    public function setIDTYPESALLE($IDTYPE_SALLE)
    {
        $this->IDTYPE_SALLE = $IDTYPE_SALLE;
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
    public function getNBRPLACES()
    {
        return $this->NBR_PLACES;
    }

    /**
     * @param mixed $NBR_PLACES
     */
    public function setNBRPLACES($NBR_PLACES)
    {
        $this->NBR_PLACES = $NBR_PLACES;
    }


}
