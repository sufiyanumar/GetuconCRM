<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function sendUpdate(Request $request, $ticket_id)
    {
        try {
            $ticket = Ticket::where('id', $ticket_id)->firstOrFail();
            $organization = Organization::where('id', $ticket->org_id)->firstOrFail();
            $user = User::where('id', $ticket->user)->firstOrFail();
            $data['subject'] = 'Ticket Update';
            // $data['to'] = 'khantufail425@gmail.com';
            $data['to'] = $user->email;
            $data['ticket'] = $ticket;
            $data['user'] = $user;
            Mail::send('emails.update-email', $data, function ($message) use ($data) {
                $message->from('crm@getucon.com', 'Getucon');
                $message->to($data['to'])->subject($data['subject']);
            });
            return redirect('ticket/' . $ticket->id);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
}
