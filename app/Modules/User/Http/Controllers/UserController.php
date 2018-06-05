<?php
namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Http\Controllers\Controller;
use App\Modules\User\Repositories\UserRepositoryEloquent;


class UserController extends Controller 
{
    protected $userRepository;
    public function __construct(UserRepositoryEloquent $userRepo)
    {
        $this->userRepository = $userRepo;
    }
    public function index()
    {
        $users = $this->userRepository->paginate(5);

        
        return response()->json($users, 200);
        
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        
        return response()->json($user, 200);
        
    }

    public function getUserInfo(Request $request)
    {
        return response()->json($request->user());
    }

}