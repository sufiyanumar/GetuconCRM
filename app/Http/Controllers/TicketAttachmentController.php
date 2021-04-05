<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketAttachment;
use Illuminate\Http\Request;
use DataTables;

class TicketAttachmentController extends Controller
{
    //
    public function index()
    {
        try {
            if (!in_array('VIEW_TICKET_ATTACHMENTS', auth()->user()->Permissions)) {
                return redirect('/dashboard');
            }
            return view('ticket-attachments.ticket-attachments');
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getTicketAttachments(Request $request)
    {
        try {
            // $tickets = Ticket::orderBy('created_at', 'ASC')->get();
            // $ticketIds = $tickets->pluck('id');
            // $ticketAttachment = TicketAttachment::whereIn('ticket_id', $ticketIds);

            $ticketAttachment = TicketAttachment::join('tickets', 'tickets.id', 'ticket_attachments.ticket_id')
                ->join('organizations', 'organizations.id', 'tickets.org_id')
                ->join('users', 'users.id', 'ticket_attachments.add_by')
                ->select('ticket_attachments.*', 'organizations.org_name as organization', 'users.first_name as installer')
                ->orderBy('ticket_attachments.id', 'DESC');
            return DataTables::of($ticketAttachment)
                ->addColumn('actions', function ($ticketAttachment) {
                    return '<a href="' . asset('/storage/uploadsnew/attach') . '/' . $ticketAttachment->attachment . '" target="_blank"><i class="fa fa-eye"></i></a>';
                })->rawColumns(['actions'])
                ->make(true);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getTicketAttachment(Request $request, $ticketId)
    {
        try {
            $ticket = Ticket::where('id', $ticketId)->firstOrFail();
            $ticket['attachment'] = TicketAttachment::where('ticket_id', $ticket->id)->get();
            return view('ticket-attachments.ticket-attachment', compact('ticket'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function addAttachment(Request $request, $ticketId)
    {
        try {
            $attachment = $request->attachment;
            $ticketAttachment = new TicketAttachment();
            $ticketAttachment->ticket_id = $ticketId;
            $ticketAttachment->attachment = $attachment;
            $ticketAttachment->add_by = auth()->user()->id;
            $ticketAttachment->add_ip = request()->ip();
            $ticketAttachment->save();
            return ['success' => 'File uploaded successfully'];
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function deleteAttachment(Request $request, $attachmentId)
    {
        try {
            $ticketAttachment = TicketAttachment::where('id', $attachmentId)->first();
            $ticketAttachment->delete();
            return ['success' => 'File deleted successfully'];
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
}
