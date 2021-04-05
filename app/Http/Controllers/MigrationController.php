<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\Imports\DiscussionImport;
use App\Imports\OrganizationImport;
use App\Imports\TicketAttachmentsImport;
use App\Imports\TicketsImport;
use App\Imports\UpdateTicketImport;
use App\Imports\UserPassword;
use App\Imports\UsersImport;
use App\OldTicket;
use App\Ticket;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MigrationController extends Controller
{
    //
    public function userMigration(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $destinationPath = storage_path() . '/app/public/temp/';
                $newname = md5('products') . rand(0, 9999) . time() . '.' . $file->guessClientExtension();
                if ($file->move($destinationPath, $newname)) {
                    if ($request->type == 'user') {
                        Excel::import(new UsersImport, storage_path() . '/app/public/temp/' . $newname);
                        return ['success' => 'Data uploaded successfully'];
                    }
                    if ($request->type == 'ticket') {
                        $tickets = Ticket::get();
                        foreach ($tickets as $ticket) {
                            $ticket->description = strip_tags($ticket->description);
                            $ticket->save();
                        }
                        // Excel::import(new TicketsImport, storage_path() . '/app/public/temp/' . $newname);
                        return ['success' => 'Data uploaded successfully'];
                    }
                    if ($request->type == 'attachments') {
                        Excel::import(new TicketAttachmentsImport, storage_path() . '/app/public/temp/' . $newname);
                        return ['success' => 'Data uploaded successfully'];
                    }
                    if ($request->type == 'organization') {
                        Excel::import(new OrganizationImport, storage_path() . '/app/public/temp/' . $newname);
                        return ['success' => 'Data uploaded successfully'];
                    }
                    if ($request->type == 'password') {
                        Excel::import(new UserPassword, storage_path() . '/app/public/temp/' . $newname);
                        return ['success' => 'Data uploaded successfully'];
                    }
                    if ($request->type == 'discussion') {
                        $discussions = Discussion::get();
                        foreach ($discussions as $discussion) {
                            $discussion->message = strip_tags($discussion->message);
                            $discussion->is_private = !$discussion->is_private;
                            $discussion->save();
                        }
                        // Excel::import(new DiscussionImport, storage_path() . '/app/public/temp/' . $newname);
                        return ['success' => 'Data uploaded successfully'];
                    }
                    if ($request->type == 'update_tickets') {
                        $oldTickets  = OldTicket::get();
                        foreach ($oldTickets as $oldTicket) {
                            $ticket = Ticket::where('id', $oldTicket->id)->first();
                            if ($ticket) {
                                $ticket->due_date = $oldTicket->due_date;
                                $ticket->created_at = $oldTicket->created_at;
                                $ticket->save();
                            }
                        }
                    }
                }
            } else {
                return ['error' => 'Please attach file'];
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
