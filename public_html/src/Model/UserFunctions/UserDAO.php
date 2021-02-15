<?php
namespace CRDV\Model\UserFunctions;

interface UserDAO {
    public function addFisicUser(User $u);
    public function addJuridicUser(User $u);
    public function delete(String $id);
    public function findAll();
    public function findByCEP(String $cep);
    public function findByCPF(String $cpf);
    public function findByResidentialPhone(String $residentialT);
    public function findByStateRegistration(String $stateR);
    public function findByEmail(String $email);
    public function findById(String $id);
    public function findByName(String $name);
    public function findBySurname(String $surname);
    public function findByTelephone(String $telephone);
    public function login(String $email, String $password);
    public function update(User $u);
}