<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class Actualite
{
    //IDACTUALITES 	DATE_ACTUALITE 	TITRE_ACTU 	DESCRIPTION_ACTU 	IDCLASSROOM 	IDETABLISSEMENT IDANNEESSCOLAIRE
    private $IDACTUALITES;
    private $DATE_ACTUALITE;
    private $TITRE_ACTU;
    private $DESCRIPTION_ACTU;
    private $IDCLASSROOM;
    private $IDETABLISSEMENT;
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
    public function getDATEACTUALITE()
    {
        return $this->DATE_ACTUALITE;
    }

    /**
     * @param mixed $DATE_ACTUALITE
     */
    public function setDATEACTUALITE($DATE_ACTUALITE)
    {
        $this->DATE_ACTUALITE = $DATE_ACTUALITE;
    }

    /**
     * @return mixed
     */
    public function getDESCRIPTIONACTU()
    {
        return $this->DESCRIPTION_ACTU;
    }

    /**
     * @param mixed $DESCRIPTION_ACTU
     */
    public function setDESCRIPTIONACTU($DESCRIPTION_ACTU)
    {
        $this->DESCRIPTION_ACTU = $DESCRIPTION_ACTU;
    }

    /**
     * @return mixed
     */
    public function getIDACTUALITES()
    {
        return $this->IDACTUALITES;
    }

    /**
     * @param mixed $IDACTUALITES
     */
    public function setIDACTUALITES($IDACTUALITES)
    {
        $this->IDACTUALITES = $IDACTUALITES;
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
    public function getTITREACTU()
    {
        return $this->TITRE_ACTU;
    }

    /**
     * @param mixed $TITRE_ACTU
     */
    public function setTITREACTU($TITRE_ACTU)
    {
        $this->TITRE_ACTU = $TITRE_ACTU;
    }



}

?>
