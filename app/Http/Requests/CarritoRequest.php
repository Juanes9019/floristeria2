<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarritoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_destinatario' => 'required|string|regex:/^[a-zA-Z\s]+$/',
            'direccion' => 'required|string|min:10',
            'instrucciones_entrega' => 'required|string|min:10',
            'telefono' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'nombre_destinatario.required' => 'Por favor, completa el nombre del destinatario.',
            'nombre_destinatario.regex' => 'Por favor, ingresa un nombre de destinatario válido.',
            'direccion.required' => 'Por favor, completa la dirección.',
            'direccion.min' => 'Ingresa una dirección válida de al menos 10 caracteres.',
            'instrucciones_entrega.required' => 'Por favor, completa las instrucciones de entrega.',
            'instrucciones_entrega.min' => 'Ingresa instrucciones válidas de al menos 10 caracteres.',
            'telefono.required' => 'Por favor, completa el teléfono.',
        ];
    }
}
