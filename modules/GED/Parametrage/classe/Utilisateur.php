<?php
/**
 * Created by PhpStorm.
 * User: abduulaay
 * Date: 23/02/16
 * Time: 18:48
 */

class Utilisateur
{
    //idUtilisateur prenomUtilisateur nomUtilisateur telephone email login password idEtablissement idProfil dateCreation userCreation dateModification userModification
    private $idUtilisateur;
    private $matriculeUtilisateur;
    private $codeUtilisateur;
    private $prenomUtilisateur;
    private $nomUtilisateur;
    private $telephone;
    private $adresse;
    private $email;
    private $login;
    private $password;
    private $idEtablissement;
    private $idProfil;
    private $dateCreation;
    private $userCreation;
    private $dateModification;
    private $userModification;


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
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * @param mixed $idUtilisateur
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;
    }

    /**
     * @return mixed
     */
    public function getNomUtilisateur()
    {
        return $this->nomUtilisateur;
    }

    /**
     * @param mixed $nomUtilisateur
     */
    public function setNomUtilisateur($nomUtilisateur)
    {
        $this->nomUtilisateur = $nomUtilisateur;
    }

    /**
     * @return mixed
     */
    public function getPrenomUtilisateur()
    {
        return $this->prenomUtilisateur;
    }

    /**
     * @param mixed $prenomUtilisateur
     */
    public function setPrenomUtilisateur($prenomUtilisateur)
    {
        $this->prenomUtilisateur = $prenomUtilisateur;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getIdEtablissement()
    {
        return $this->idEtablissement;
    }

    /**
     * @param mixed $idEtablissement
     */
    public function setIdEtablissement($idEtablissement)
    {
        $this->idEtablissement = $idEtablissement;
    }

    /**
     * @return mixed
     */
    public function getIdProfil()
    {
        return $this->idProfil;
    }

    /**
     * @param mixed $idProfil
     */
    public function setIdProfil($idProfil)
    {
        $this->idProfil = $idProfil;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return mixed
     */
    public function getUserCreation()
    {
        return $this->userCreation;
    }

    /**
     * @param mixed $userCreation
     */
    public function setUserCreation($userCreation)
    {
        $this->userCreation = $userCreation;
    }

    /**
     * @return mixed
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * @param mixed $dateModification
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;
    }

    /**
     * @return mixed
     */
    public function getUserModification()
    {
        return $this->userModification;
    }

    /**
     * @param mixed $userModification
     */
    public function setUserModification($userModification)
    {
        $this->userModification = $userModification;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getCodeUtilisateur()
    {
        return $this->codeUtilisateur;
    }

    /**
     * @param mixed $codeUtilisateur
     */
    public function setCodeUtilisateur($codeUtilisateur)
    {
        $this->codeUtilisateur = $codeUtilisateur;
    }

    /**
     * @return mixed
     */
    public function getMatriculeUtilisateur()
    {
        return $this->matriculeUtilisateur;
    }

    /**
     * @param mixed $matriculeUtilisateur
     */
    public function setMatriculeUtilisateur($matriculeUtilisateur)
    {
        $this->matriculeUtilisateur = $matriculeUtilisateur;
    }




}
