<?php

namespace CRDV\Model\UserFunctions;

require(dirname(__DIR__,3)."/vendor/autoload.php");

class UserDAOMongoDB implements UserDAO{
    /**
     * @param User $u
     * @return mixed
     */
    public function add(User $u)
    {
        // TODO: Implement add() method.
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param String $email
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        // TODO: Implement findByEmail() method.
    }

    /**
     * @param String $id
     * @return mixed
     */
    public function findById(string $id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        // TODO: Implement findByName() method.
    }

    /**
     * @param String $surname
     * @return mixed
     */
    public function findBySurname(string $surname)
    {
        // TODO: Implement findBySurname() method.
    }

    /**
     * @param String $telephone
     * @return mixed
     */
    public function findByTelephone(string $telephone)
    {
        // TODO: Implement findByTelephone() method.
    }

    /**
     * @param String $cep
     * @return mixed
     */
    public function findByCEP(string $cep)
    {
        // TODO: Implement findByCEP() method.
    }

    /**
     * @param User $u
     * @return mixed
     */
    public function update(User $u)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }


}