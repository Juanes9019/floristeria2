<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    // Sobrescribe la ruta de redirección a la raíz
    protected $redirectTo = '/';

    /**
     * Sobrescribir la función para validar y resetear la contraseña.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        // Validar los datos de la nueva contraseña
        $validator = Validator::make($request->all(), [
            'password' => [
                'required', 
                'string', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_])([A-Za-z\d$@$!%*?&_]|[^ ]){8,15}$/', 
                'min:8', 
                'max:15'
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ]
        ]);

        // Si la validación falla, redirige de vuelta con los errores
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si pasa la validación, proceder con el restablecimiento de la contraseña
        $resetStatus = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        // Si el restablecimiento fue exitoso, redirigir al usuario
        if ($resetStatus) {
            return redirect($this->redirectTo)->with('status', 'Contraseña restablecida correctamente');
        }

        // Si hubo algún error durante el proceso de restablecimiento, redirigir con un mensaje de error
        return redirect()->back()->with('error', 'Hubo un error al restablecer la contraseña');
    }
}
