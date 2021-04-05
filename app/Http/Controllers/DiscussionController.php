<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscussionController extends Controller
{
    //
    public function createDiscussion(Request $request, $ticketId)
    {
        try {
            $rules = array(
                'discussion' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('ticket/' . $ticketId)->withInput()->withErrors($validator->errors()->all());
            }
            $private = $request->private;
            $ticket = Ticket::where('id', $ticketId)->firstOrFail();
            $discussion = new Discussion();
            $discussion->message = $request->discussion;
            $discussion->user_id = auth()->user()->id;
            $discussion->ticket_id = $ticketId;
            if ($private)
                $discussion->org_id = auth()->user()->org_id;
            else
                $discussion->org_id = $ticket->org_id;
            $discussion->is_private = $private;
            $discussion->save();
            return redirect('ticket/' . $ticket->id);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function changeMessageStatus(Request $request, $messageId)
    {
        try {
            $private = $request->private;
            $discussion = Discussion::where('id', $messageId)->first();
            $discussion->is_private = $private;
            $discussion->save();
            return redirect('ticket/' . $discussion->ticket_id);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
}
