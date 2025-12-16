<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'lastname' => 'nullable|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:30',
            'subject' => 'required|string|max:150',
            'message' => 'required|string',
            'terms' => 'accepted',
        ]);

        Mail::to(config('mail.from.address'))
            ->send(new ContactMessage($data));

        return response()->json([
            'message' => 'Mensaje enviado correctamente'
        ]);
    }
}
