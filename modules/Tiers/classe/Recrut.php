<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Recrut
{
    //IDRECRUTE_PROF TARIF_HORAIRE VOLUME_HORAIRE IDETABLISSEMENT IDINDIVIDU IDMATIERE IDCLASSROOM IDANNEESSCOLAIRE
    private $IDRECRUTE_PROF;
    private $TARIF_HORAIRE;
    private $VOLUME_HORAIRE;
    private $IDETABLISSEMENT;
    private $IDINDIVIDU;
    private $IDANNEESSCOLAIRE;




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

    /**
     * @return mixed
     */
    public function getIDRECRUTEPROF()
    {
        return $this->IDRECRUTE_PROF;
    }

    /**
     * @param mixed $IDRECRUTE_PROF
     */
    public function setIDRECRUTEPROF($IDRECRUTE_PROF)
    {
        $this->IDRECRUTE_PROF = $IDRECRUTE_PROF;
    }

    /**
     * @return mixed
     */
    public function getTARIFHORAIRE()
    {
        return $this->TARIF_HORAIRE;
    }

    /**
     * @param mixed $TARIF_HORAIRE
     */
    public function setTARIFHORAIRE($TARIF_HORAIRE)
    {
        $this->TARIF_HORAIRE = $TARIF_HORAIRE;
    }

    /**
     * @return mixed
     */
    public function getVOLUMEHORAIRE()
    {
        return $this->VOLUME_HORAIRE;
    }

    /**
     * @param mixed $VOLUME_HORAIRE
     */
    public function setVOLUMEHORAIRE($VOLUME_HORAIRE)
    {
        $this->VOLUME_HORAIRE = $VOLUME_HORAIRE;
    }


}