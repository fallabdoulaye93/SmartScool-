<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class TypeControle
{
    //<!--  	IDTYP_CONTROL LIB_TYPCONTROL POIDS IDETABLISSEMENT COULEUR -->
    private $IDTYP_CONTROL;
    private $LIB_TYPCONTROL;
    private $POIDS;
    private $IDETABLISSEMENT;
    private $COULEUR;




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
    public function getCOULEUR()
    {
        return $this->COULEUR;
    }

    /**
     * @param mixed $COULEUR
     */
    public function setCOULEUR($COULEUR)
    {
        $this->COULEUR = $COULEUR;
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
    public function getIDTYPCONTROL()
    {
        return $this->IDTYP_CONTROL;
    }

    /**
     * @param mixed $IDTYP_CONTROL
     */
    public function setIDTYPCONTROL($IDTYP_CONTROL)
    {
        $this->IDTYP_CONTROL = $IDTYP_CONTROL;
    }

    /**
     * @return mixed
     */
    public function getLIBTYPCONTROL()
    {
        return $this->LIB_TYPCONTROL;
    }

    /**
     * @param mixed $LIB_TYPCONTROL
     */
    public function setLIBTYPCONTROL($LIB_TYPCONTROL)
    {
        $this->LIB_TYPCONTROL = $LIB_TYPCONTROL;
    }

    /**
     * @return mixed
     */
    public function getPOIDS()
    {
        return $this->POIDS;
    }

    /**
     * @param mixed $POIDS
     */
    public function setPOIDS($POIDS)
    {
        $this->POIDS = $POIDS;
    }



}
