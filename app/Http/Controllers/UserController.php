<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends BaseController
{

    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct($userRepository);
    }
    public function index()
    {
        $users = $this->userRepository->all();
        return Inertia::render('Users/Index', ['users' => $users]);
    }

    public function destroy($id)
    {

        $user = $this->userRepository->find($id);
        $user->posts()->delete(); // Remove associated posts
        $user->delete(); // Remove user
        return redirect()->route('app');
    }

}
