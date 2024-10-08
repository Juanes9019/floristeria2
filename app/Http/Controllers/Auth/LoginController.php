<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['estado'] = 1; // Solo permite usuarios con estado = 1
        return $credentials;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where($this->username(), $request->{$this->username()})->first();

        if ($user && $user->estado == 0) {
            throw ValidationException::withMessages([
                $this->username() => ['No puedes iniciar sesión, tu cuenta ha sido inhabilitada. :('],
            ]);
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function redirectPath()
    {
        $role = auth()->user()->id_rol;

        if ($role == 1) {
            return 'admin/dashboard';
        }
        return '/';
    }
}
