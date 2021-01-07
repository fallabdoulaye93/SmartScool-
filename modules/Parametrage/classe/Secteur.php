<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 18:48
 */

class Secteur
{
    private $IDSECTEUR;
    private $LIBELLE;

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
    public function getIDSECTEUR()
    {
        return $this->IDSECTEUR;
    }

    /**
     * @param mixed $IDSECTEUR
     */
    public function setIDSECTEUR($IDSECTEUR)
    {
        $this->IDSECTEUR = $IDSECTEUR;
    }

    /**
     * @return mixed
     */
    public function getLIBELLE()
    {
        return $this->LIBELLE;
    }

    /**
     * @param mixed $TYPE_SALLE
     */
    public function setLIBELLE($LIBELLE)
    {
        $this->LIBELLE = $LIBELLE;
    }

}