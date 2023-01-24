<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class JourFeries
{
    //IDJOUR_FERIES LIB_VACANCES DATE_DEBUT DATE_FIN IDETABLISSEMENT
    private $IDJOUR_FERIES;
    private $LIB_VACANCES;
    private $DATE_DEBUT;
    private $DATE_FIN;
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
    public function getIDJOURFERIES()
    {
        return $this->IDJOUR_FERIES;
    }

    /**
     * @param mixed $IDJOUR_FERIES
     */
    public function setIDJOURFERIES($IDJOUR_FERIES)
    {
        $this->IDJOUR_FERIES = $IDJOUR_FERIES;
    }

    /**
     * @return mixed
     */
    public function getLIBVACANCES()
    {
        return $this->LIB_VACANCES;
    }

    /**
     * @param mixed $LIB_VACANCES
     */
    public function setLIBVACANCES($LIB_VACANCES)
    {
        $this->LIB_VACANCES = $LIB_VACANCES;
    }

    /**
     * @return mixed
     */
    public function getDATEDEBUT()
    {
        return $this->DATE_DEBUT;
    }

    /**
     * @param mixed $DATE_DEBUT
     */
    public function setDATEDEBUT($DATE_DEBUT)
    {
        $this->DATE_DEBUT = $DATE_DEBUT;
    }

    /**
     * @return mixed
     */
    public function getDATEFIN()
    {
        return $this->DATE_FIN;
    }

    /**
     * @param mixed $DATE_FIN
     */
    public function setDATEFIN($DATE_FIN)
    {
        $this->DATE_FIN = $DATE_FIN;
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
