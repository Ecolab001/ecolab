<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'terms' => 'accepted'
        ]);

        Contact::create($request->all());

        return back()->with('success', 'Message envoyé avec succès');
    }
}