<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $users = User::where('type', 0)->latest()->get();
        return view('contacts.index', compact('users'));
    }

    public function open($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('contact.index')->with('message', __('auth.failed'));
        }

        return view('contacts.send', compact('user'));
    }

    public function send(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('contact.index')->with('message', __('auth.failed'));
        }

        $this->validate($request, [
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);

        $subject = $request->subject;
        $message = $request->message;
        $out = [$subject, $message];
        $email = $user->email;

        try {
            Mail::send('Mails.contact', ['out' => $out], function (Message $message) use ($email, $subject) {
                $message->to($email);
                $message->subject($subject);
            });

            return redirect()->route('contact.index')->with('message', __('contact.msgSuccess'));
        } catch (\Exception $exception) {
            return redirect()->route('contact.index')->with('message', __('contact.msgFailed'));
        }
    }
}
