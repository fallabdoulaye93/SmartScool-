<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class PeriodeScolaire
{
    //IDPERIODE NOM_PERIODE DEBUT_PERIODE FIN_FPERIODE IDANNEESSCOLAIRE IDETABLISSEMENT
    private $IDPERIODE;
    private $NOM_PERIODE;
    private $DEBUT_PERIODE;
    private $FIN_FPERIODE;
    private $IDANNEESSCOLAIRE;
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
    public function getIDPERIODE()
    {
        return $this->IDPERIODE;
    }

    /**
     * @param mixed $IDPERIODE
     */
    public function setIDPERIODE($IDPERIODE)
    {
        $this->IDPERIODE = $IDPERIODE;
    }

    /**
     * @return mixed
     */
    public function getNOMPERIODE()
    {
        return $this->NOM_PERIODE;
    }

    /**
     * @param mixed $NOM_PERIODE
     */
    public function setNOMPERIODE($NOM_PERIODE)
    {
        $this->NOM_PERIODE = $NOM_PERIODE;
    }

    /**
     * @return mixed
     */
    public function getDEBUTPERIODE()
    {
        return $this->DEBUT_PERIODE;
    }

    /**
     * @param mixed $DEBUT_PERIODE
     */
    public function setDEBUTPERIODE($DEBUT_PERIODE)
    {
        $this->DEBUT_PERIODE = $DEBUT_PERIODE;
    }

    /**
     * @return mixed
     */
    public function getFINFPERIODE()
    {
        return $this->FIN_FPERIODE;
    }

    /**
     * @param mixed $FIN_FPERIODE
     */
    public function setFINFPERIODE($FIN_FPERIODE)
    {
        $this->FIN_FPERIODE = $FIN_FPERIODE;
    }

    /**
     * @return mixed
     */
    public function getIDANNEESSCOLAIRE()
    {
        return $this->IDANNEESSCOLAIRE;
    }

    /**
     * @param mixed $IDANNEESSCOLAIRE
     */
    public function setIDANNEESSCOLAIRE($IDANNEESSCOLAIRE)
    {
        $this->IDANNEESSCOLAIRE = $IDANNEESSCOLAIRE;
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