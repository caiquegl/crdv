<?php

namespace CRDV\Model\AdminFunctions;

use CRDV\Model\UserFunctions\User;
use CRDV\Model\UserFunctions\UserDAO;

interface AdminInterface{
    public function addBanner($image);
    public function updateClient(UserDAO $userDb, User $user);
    public function delBanner(String $banner);
}