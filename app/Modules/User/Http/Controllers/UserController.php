<?php
namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            $response = [];
            foreach ($validator->messages() as $key => $value) {
                $response[$key] = $value;
            }
            //$response['status'] = '500';
            return response()->json($validator->messages(), 500);
        } else {
            try{
                $user = $this->userRepository->saveNewUser($request->all());            
                return response()->json($user, 200);
            }catch(Exception $e){
                throw new Exception("Error Processing Request", $e);                
            }
            
        }

    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        
        return response()->json($user, 200);
        
    }

    public function update(Request $request, $id)
    {        
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        } else {
            try{
                //var_dump($request->all());
                $user = $this->userRepository->update($request->all(),$id);            
                return response()->json($user, 200);
            }catch(Exception $e){
                throw new Exception("Error Processing Request", $e);                
            }
            
        }        
    }

    public function destroy($id)
    {
        try{
            $this->userRepository->delete($id);
            return response()->json(['message' => 'Successful deleted'], 200);
        }catch(Exception $e){
            throw new Exception("Error Processing Request", $e);
            
        }
    }

    public function getUserInfo(Request $request)
    {
        return response()->json($request->user());
    }

}