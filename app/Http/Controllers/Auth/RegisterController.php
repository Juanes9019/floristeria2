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
            'name' => ['required','regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/','max:30'],
            'surname' => ['required','regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/','max:30'],
            'email' => 'required|email|unique:users,email',
            'tipo_documento' => 'required',
            'documento' => 'required|unique:users,documento',
            'celular' => ['required', 'string', 'size:10'],
            'password' => ['required', 'string', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_])([A-Za-z\d$@$!%*?&_]|[^ ]){8,15}$/','min:8','max:15'],
            'cpassword' => ['required', 'same:password']
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'tipo_documento' => $data['tipo_documento'],
            'documento' => $data['documento'],
            'celular' => $data['celular'],
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
