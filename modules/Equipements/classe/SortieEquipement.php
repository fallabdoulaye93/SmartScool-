<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class SortieEquipement
{
    // 	ID_SORTI_EQUIPEMENT ID_EQUIPEMENT NOMBRE_SORTI DATE_SORTI IDETABLISSEMENT
    private $ID_SORTI_EQUIPEMENT;
    private $ID_EQUIPEMENT;
    private $NOMBRE_SORTI;
    private $DATE_SORTI;
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
    public function getIDSORTIEQUIPEMENT()
    {
        return $this->ID_SORTI_EQUIPEMENT;
    }

    /**
     * @param mixed $ID_SORTI_EQUIPEMENT
     */
    public function setIDSORTIEQUIPEMENT($ID_SORTI_EQUIPEMENT)
    {
        $this->ID_SORTI_EQUIPEMENT = $ID_SORTI_EQUIPEMENT;
    }

    /**
     * @return mixed
     */
    public function getIDEQUIPEMENT()
    {
        return $this->ID_EQUIPEMENT;
    }

    /**
     * @param mixed $ID_EQUIPEMENT
     */
    public function setIDEQUIPEMENT($ID_EQUIPEMENT)
    {
        $this->ID_EQUIPEMENT = $ID_EQUIPEMENT;
    }

    /**
     * @return mixed
     */
    public function getNOMBRESORTI()
    {
        return $this->NOMBRE_SORTI;
    }

    /**
     * @param mixed $NOMBRE_SORTI
     */
    public function setNOMBRESORTI($NOMBRE_SORTI)
    {
        $this->NOMBRE_SORTI = $NOMBRE_SORTI;
    }

    /**
     * @return mixed
     */
    public function getDATESORTI()
    {
        return $this->DATE_SORTI;
    }

    /**
     * @param mixed $DATE_SORTI
     */
    public function setDATESORTI($DATE_SORTI)
    {
        $this->DATE_SORTI = $DATE_SORTI;
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