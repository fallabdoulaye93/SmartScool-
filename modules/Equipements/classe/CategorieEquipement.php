<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class CategorieEquipement
{
    // 	IDCATEGEQUIP LIBELLE IDETABLISSEMENT
    private $IDCATEGEQUIP;
    private $LIBELLE;
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
    public function getIDCATEGEQUIP()
    {
        return $this->IDCATEGEQUIP;
    }

    /**
     * @param mixed $IDANNEESSCOLAIRE
     */
    public function setIDCATEGEQUIP($IDCATEGEQUIP)
    {
        $this->IDCATEGEQUIP = $IDCATEGEQUIP;
    }

    /**
     * @return mixed
     */
    public function getLIBELLE()
    {
        return $this->LIBELLE;
    }

    /**
     * @param mixed $LIBELLE_ANNEESSOCLAIRE
     */
    public function setLIBELLE($LIBELLE)
    {
        $this->LIBELLE = $LIBELLE;
    }

    /**
     * @return mixed
     */
    public function getIDETABLISSEMENT()
    {
        return $this->IDETABLISSEMENT;
    }

    /**
     * @param mixed $DATE_DEBUT
     */
    public function setIDETABLISSEMENT($IDETABLISSEMENT)
    {
        $this->IDETABLISSEMENT = $IDETABLISSEMENT;
    }

    

}
