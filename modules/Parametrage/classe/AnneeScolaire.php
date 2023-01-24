<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class AnneeScolaire
{
    //IDANNEESSCOLAIRE LIBELLE_ANNEESSOCLAIRE DATE_DEBUT DATE_FIN IDETABLISSEMENT
    private $IDANNEESSCOLAIRE;
    private $LIBELLE_ANNEESSOCLAIRE;
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
    public function getLIBELLEANNEESSOCLAIRE()
    {
        return $this->LIBELLE_ANNEESSOCLAIRE;
    }

    /**
     * @param mixed $LIBELLE_ANNEESSOCLAIRE
     */
    public function setLIBELLEANNEESSOCLAIRE($LIBELLE_ANNEESSOCLAIRE)
    {
        $this->LIBELLE_ANNEESSOCLAIRE = $LIBELLE_ANNEESSOCLAIRE;
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
