<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Filiere
{
    //IDSERIE LIBSERIE IDETABLISSEMENT
    private $IDSERIE;
    private $LIBSERIE;
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
    public function getIDSERIE()
    {
        return $this->IDSERIE;
    }

    /**
     * @param mixed $IDSERIE
     */
    public function setIDSERIE($IDSERIE)
    {
        $this->IDSERIE = $IDSERIE;
    }

    /**
     * @return mixed
     */
    public function getLIBSERIE()
    {
        return $this->LIBSERIE;
    }

    /**
     * @param mixed $LIBSERIE
     */
    public function setLIBSERIE($LIBSERIE)
    {
        $this->LIBSERIE = $LIBSERIE;
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