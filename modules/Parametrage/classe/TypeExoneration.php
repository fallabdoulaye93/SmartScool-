<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class TypeExoneration
{
    //IDTYPE_SALLE TYPE_SALLE IDETABLISSEMENT
    private $ROWID;
    private $LABEL;
    private $ETAT;



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
     * @param mixed $LABEL
     */
    public function setLABEL($LABEL)
    {
        $this->LABEL = $LABEL;
    }

    /**
     * @return mixed
     */
    public function getETAT()
    {
        return $this->ETAT;
    }

    /**
     * @param mixed $ETAT
     */
    public function setETAT($ETAT)
    {
        $this->ETAT = $ETAT;
    }


}
