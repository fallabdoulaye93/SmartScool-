<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 19:04
 */
require(dirname(__FILE__).'/Uniforme.php');
require_once("../manager.php");

class UniformeManager extends manager{

    /**
     * EvenementManager constructor.
     * @param $_db
     * @param $_table
     */
    public function __construct($db,$table)
    {
        parent::__construct($db,$table);
    }

    function insert($values) {
        $donnees=parent::insert($values);
        return $donnees;
    }

    function modifier($values,$idField,$idValue) {
        $info=parent::modifier($values,$idField,$idValue);
        return $info;
    }

    public function supprimer($fieldId,$idValue)
    {
        $info=parent::supprimer($fieldId,$idValue);
        return $info;
    }

}
