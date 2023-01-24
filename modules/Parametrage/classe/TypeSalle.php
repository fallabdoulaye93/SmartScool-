<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class TypeSalle
{
    //IDTYPE_SALLE TYPE_SALLE IDETABLISSEMENT
    private $IDTYPE_SALLE;
    private $TYPE_SALLE;
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
    public function getIDTYPE_SALLE()
    {
        return $this->IDTYPE_SALLE;
    }

    /**
     * @param mixed $IDTYPE_SALLE
     */
    public function setIDTYPE_SALLE($IDTYPE_SALLE)
    {
        $this->IDTYPE_SALLE = $IDTYPE_SALLE;
    }

    /**
     * @return mixed
     */
    public function getTYPE_SALLE()
    {
        return $this->TYPE_SALLE;
    }

    /**
     * @param mixed $TYPE_SALLE
     */
    public function setTYPE_SALLE($TYPE_SALLE)
    {
        $this->TYPE_SALLE = $TYPE_SALLE;
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
