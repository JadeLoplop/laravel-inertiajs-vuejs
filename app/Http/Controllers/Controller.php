<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public function __construct(\App\Repositories\UserRepository $userRepository)
    {
    }
}
