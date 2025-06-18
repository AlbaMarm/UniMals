<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function pintarFormulario()
    {
        return view('formcorreos.fcontacto');
    }

    public function procesarFormulario(Request $request)
    {
        $destinatario = config('mail.from.address');

        $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:60'],
            'body' => ['required', 'string', 'min:10', 'max:150'],
        ]);

        try {
            Mail::to($destinatario)
                ->send(new ContactoMailable(
                    $request->name,
                    $request->body
                ));

            return redirect()->route('contacto.form')
                             ->with('mensaje', 'Email sent successfully!');
        } catch (\Exception $ex) {
            return redirect()->route('contacto.form')
                             ->with('mensaje', 'Error! The mail could not be sent.');
        }
    }
}
