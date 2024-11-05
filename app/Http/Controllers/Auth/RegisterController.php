<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'celular' => ['required', 'string', 'max:20'],   
            'direccion' => ['required', 'string', 'max:255'], 
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'celular' => $data['celular'],
            'direccion' => $data['direccion'],
            'password' => Hash::make($data['password']),
            'id_rol' => 2, 
        ]);
    }

    protected function redirectTo()
    {
        $role = auth()->user()->id_rol;

        if ($role == 1) {
            return 'dashboard';
        }
        return '/';
    }
}
