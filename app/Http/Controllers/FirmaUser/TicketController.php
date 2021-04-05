<?php

namespace App\Http\Controllers\FirmaUser;

use App\Http\Controllers\Controller;
use App\Category;
use App\GoodWill;
use App\Status;
use App\Ticket;
use App\TicketAttachment;
use App\TicketStatus;
use App\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        try {
            $statuses = Status::get();
            return view('tickets.tickets', compact('statuses'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function ticketIndex(Request $request, $ticketId)
    {
        try {
            $ticket = Ticket::where('id', $ticketId)->firstOrFail();
            $ticket['attachment'] = TicketAttachment::where('ticket_id', $ticket->id)->get();
            return view('tickets.ticket')->with('ticket', $ticket);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function addTicketIndex(Request $request)
    {
        try {
            $data['status'] = Status::get();
            $data['category'] = Category::get();
            $data['goodWill'] = GoodWill::get();
            return view('tickets.add-ticket', compact('data'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function updatedTicketIndex(Request $request, $ticketId)
    {
        try {
            $data['status'] = Status::get();
            $data['category'] = Category::get();
            $data['goodWill'] = GoodWill::get();
            $ticket = Ticket::where('id', $ticketId)->firstOrFail();
            $ticket['attachment'] = TicketAttachment::where('ticket_id', $ticket->id)->get();
            return view('tickets.update-ticket', compact('ticket', 'data'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getTickets(Request $request)
    {
        try {
            if (auth()->user()->role_id == 1) {
                if ($request->status == 'all')
                    $tickets = Ticket::get();
                else
                    $tickets = Ticket::where('status_id', $request->status)->get();
            } else {
                if ($request->status == 'all')
                    $tickets = Ticket::where('user', auth()->user()->id)->get();
                else
                    $tickets = Ticket::where('status_id', $request->status)->where('user', auth()->user()->id)->get();
            }
            return DataTables::of($tickets)
                ->addColumn('actions', function ($tickets) {
                    if (in_array('UPDATE_TICKET', auth()->user()->Permissions) && in_array('DELETE_TICKET', auth()->user()->Permissions))
                        return '<a href="' . url('/update-ticket' . '/' . $tickets->id) . '"><i class="fa fa-pencil btn btn-warning"></i></a> | <a href="#" data-id="' . $tickets->id . '" class="deleteTicket"><i class="fa fa-trash btn btn-danger"></i></a>';
                    if (!in_array('UPDATE_TICKET', auth()->user()->Permissions) && in_array('DELETE_TICKET', auth()->user()->Permissions))
                        return '<a href="#" data-id="' . $tickets->id . '" class="deleteTicket"><i class="fa fa-trash btn btn-danger"></i></a>';
                    if (in_array('UPDATE_TICKET', auth()->user()->Permissions) && !in_array('DELETE_TICKET', auth()->user()->Permissions))
                        return '<a href="' . url('/update-ticket' . '/' . $tickets->id) . '"><i class="fa fa-pencil btn btn-warning"></i></a>';
                    if (!in_array('UPDATE_TICKET', auth()->user()->Permissions) && !in_array('DELETE_TICKET', auth()->user()->Permissions))
                        return '-';
                })->rawColumns(['actions'])
                ->make(true);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function createTicket(Request $request)
    {
        try {
            $rules = array(
                'name' => 'required',
                'organization' => 'required',
                'user' => 'required',
                'personnel' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('add-ticket')->withInput()->withErrors($validator->errors()->all());
            }
            $ticket = new Ticket();
            $ticket->name = $request->name;
            $ticket->description = $request->description;
            $ticket->translate = $request->translateToggle ? $request->translate : '';
            $ticket->org_id = $request->organization;
            $ticket->user = $request->user;
            $ticket->personnel = $request->personnel;
            $ticket->status_id = $request->status;
            $ticket->due_date = $request->due_date;
            $ticket->priority = $request->priority;
            $ticket->category = $request->category;
            $ticket->good_will = $request->good_will;
            $ticket->coding = $request->coding;
            $ticket->consulting = $request->consulting;
            $ticket->testing = $request->testing;
            $ticket->total_time = date("H:i:s", strtotime($request->coding) + strtotime($request->consulting) + strtotime($request->testing));
            $ticket->transport_price = $request->transport_price;
            $ticket->add_by = auth()->user()->id;
            $ticket->add_ip = request()->ip();
            $ticket->update_by = auth()->user()->id;
            $ticket->update_ip = request()->ip();
            $ticket->save();

            if ($request->ticketAttachments) {
                foreach ($request->ticketAttachments as $attachment) {
                    $ticketAttachment = new TicketAttachment();
                    $ticketAttachment->ticket_id = $ticket->id;
                    $ticketAttachment->attachment = $attachment;
                    $ticketAttachment->add_by = auth()->user()->id;
                    $ticketAttachment->add_ip = request()->ip();
                    $ticketAttachment->save();
                }
            }
            return redirect('ticket/' . $ticket->id);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function editTicket(Request $request, $ticketId)
    {
        try {
            $rules = array(
                'name' => 'required',
                'organization' => 'required',
                'user' => 'required',
                'personnel' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('update-ticket')->withInput()->withErrors($validator->errors()->all());
            }
            $ticket = Ticket::where('id', $ticketId)->firstOrFail();
            $ticket->name = $request->name;
            $ticket->description = $request->description;
            $ticket->translate = $request->translateToggle ? $request->translate : '';
            $ticket->org_id = $request->organization;
            $ticket->user = $request->user;
            $ticket->personnel = $request->personnel;
            if ($request->status != $ticket->status_id) {
                $ticketStatus = new TicketStatus();
                $ticketStatus->ticket_id = $ticket->id;
                $ticketStatus->status = $request->status;
                $ticketStatus->add_by = auth()->user()->id;
                $ticketStatus->add_ip = request()->ip();
                $ticketStatus->save();
            }
            $ticket->status_id = $request->status;
            $ticket->due_date = $request->due_date;
            $ticket->priority = $request->priority;
            $ticket->category = $request->category;
            $ticket->good_will = $request->good_will;
            $ticket->coding = $request->coding;
            $ticket->consulting = $request->consulting;
            $ticket->testing = $request->testing;
            $ticket->transport_price = $request->transport_price;
            $ticket->update_by = auth()->user()->id;
            $ticket->update_ip = request()->ip();
            if ($request->ticketAttachments) {
                foreach ($request->ticketAttachments as $attachment) {
                    $ticketAttachment = new TicketAttachment();
                    $ticketAttachment->ticket_id = $ticket->id;
                    $ticketAttachment->attachment = $attachment;
                    $ticketAttachment->add_by = auth()->user()->id;
                    $ticketAttachment->add_ip = request()->ip();
                    $ticketAttachment->save();
                }
            }
            $ticket->save();
            return redirect('ticket/' . $ticket->id);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function removeAttachment(Request $request, $attachmentId)
    {
        try {
            $ticketAttachment = TicketAttachment::where('id', $attachmentId)->firstOrFail();
            $ticketAttachment->delete();
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function deleteTicket(Request $request, $ticketId)
    {
        try {
            $ticket = Ticket::where('id', $ticketId)->firstOrFail();
            $ticket->delete();
            return redirect('tickets')->with('success', 'Ticket deleted successfully');
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
}
