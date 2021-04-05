<?php

namespace App\Http\Controllers;

use App\Category;
use App\Discussion;
use App\GoodWill;
use App\Organization;
use App\Priority;
use App\Status;
use App\Ticket;
use App\TicketAttachment;
use App\TicketStatus;
use App\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            if (!in_array('VIEW_TICKETS', auth()->user()->Permissions)) {
                return redirect('/dashboard');
            }
            $statuses = Status::get();
            if (auth()->user()->role_id == 1) {
                //For Super Admin
                $tickets = Ticket::get();
                $totalTickets = $tickets->count();
                $openTickets = $tickets->where('status_id', 1)->count();
                $transferedTickets = $tickets->where('status_id', 2)->count();
                $inProgressTickets = $tickets->where('status_id', 3)->count();
                $answeredTickets = $tickets->where('status_id', 4)->count();
                $queryTickets = $tickets->where('status_id', 5)->count();
                $doneTickets = $tickets->where('status_id', 6)->count();
                $invoicedTickets = $tickets->where('status_id', 7)->count();
                $onHoldTickets = $tickets->where('status_id', 8)->count();
                $closedTickets = $tickets->where('status_id', 9)->count();
            }
            if (auth()->user()->role_id == 2) {
                $tickets = Ticket::get();
                $totalTickets = $tickets->count();
                $openTickets = $tickets->where('status_id', 1)->count();
                $transferedTickets = $tickets->where('status_id', 2)->count();
                $inProgressTickets = $tickets->where('status_id', 3)->count();
                $answeredTickets = $tickets->where('status_id', 4)->count();
                $queryTickets = $tickets->where('status_id', 5)->count();
                $doneTickets = $tickets->where('status_id', 6)->count();
                $invoicedTickets = $tickets->where('status_id', 7)->count();
                $onHoldTickets = $tickets->where('status_id', 8)->count();
                $closedTickets = $tickets->where('status_id', 9)->count();
            }
            if (auth()->user()->role_id == 3) { //For Personnel Admin
                $users = User::where('personnel', auth()->user()->id)->get();
                $userIds = $users->pluck('id');
                $tickets = Ticket::whereIn('personnel', $userIds)->orWhere('personnel', auth()->user()->id)->get();

                $totalTickets = $tickets->count();
                $openTickets = $tickets->where('status_id', 1)->count();
                $transferedTickets = $tickets->where('status_id', 2)->count();
                $inProgressTickets = $tickets->where('status_id', 3)->count();
                $answeredTickets = $tickets->where('status_id', 4)->count();
                $queryTickets = $tickets->where('status_id', 5)->count();
                $doneTickets = $tickets->where('status_id', 6)->count();
                $invoicedTickets = $tickets->where('status_id', 7)->count();
                $onHoldTickets = $tickets->where('status_id', 8)->count();
                $closedTickets = $tickets->where('status_id', 9)->count();
            }
            if (auth()->user()->role_id == 4) { //For Personnel
                $users = User::where('personnel', auth()->user()->id)->get();
                $userIds = $users->pluck('id');
                $tickets = Ticket::where('personnel',  auth()->user()->id)->get();

                $totalTickets = $tickets->count();
                $openTickets = $tickets->where('status_id', 1)->count();
                $transferedTickets = $tickets->where('status_id', 2)->count();
                $inProgressTickets = $tickets->where('status_id', 3)->count();
                $answeredTickets = $tickets->where('status_id', 4)->count();
                $queryTickets = $tickets->where('status_id', 5)->count();
                $doneTickets = $tickets->where('status_id', 6)->count();
                $invoicedTickets = $tickets->where('status_id', 7)->count();
                $onHoldTickets = $tickets->where('status_id', 8)->count();
                $closedTickets = $tickets->where('status_id', 9)->count();
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                $tickets = Ticket::where('org_id', auth()->user()->org_id)->get();

                $totalTickets = $tickets->count();
                $openTickets = $tickets->where('status_id', 1)->count();
                $transferedTickets = $tickets->where('status_id', 2)->count();
                $inProgressTickets = $tickets->where('status_id', 3)->count();
                $answeredTickets = $tickets->where('status_id', 4)->count();
                $queryTickets = $tickets->where('status_id', 5)->count();
                $doneTickets = $tickets->where('status_id', 6)->count();
                $invoicedTickets = $tickets->where('status_id', 7)->count();
                $onHoldTickets = $tickets->where('status_id', 8)->count();
                $closedTickets = $tickets->where('status_id', 9)->count();
            }
            if (auth()->user()->role_id == 6) { //For Firma User
                $users = User::where('personnel', auth()->user()->id)->get();
                $userIds = $users->pluck('id');
                $tickets = Ticket::where('user',  auth()->user()->id)->get();

                $totalTickets = $tickets->count();
                $openTickets = $tickets->where('status_id', 1)->count();
                $transferedTickets = $tickets->where('status_id', 2)->count();
                $inProgressTickets = $tickets->where('status_id', 3)->count();
                $answeredTickets = $tickets->where('status_id', 4)->count();
                $queryTickets = $tickets->where('status_id', 5)->count();
                $doneTickets = $tickets->where('status_id', 6)->count();
                $invoicedTickets = $tickets->where('status_id', 7)->count();
                $onHoldTickets = $tickets->where('status_id', 8)->count();
                $closedTickets = $tickets->where('status_id', 9)->count();
            }

            $data['totalTickets'] = $totalTickets;
            $data['totalOpenTickets'] = $openTickets;
            $data['transferedTickets'] = $transferedTickets;
            $data['inProgressTickets'] = $inProgressTickets;
            $data['answeredTickets'] = $answeredTickets;
            $data['queryTickets'] = $queryTickets;
            $data['doneTickets'] = $doneTickets;
            $data['invoicedTickets'] = $invoicedTickets;
            $data['onHoldTickets'] = $onHoldTickets;
            $data['closedTickets'] = $closedTickets;

            if (auth()->user()->role_id != 5 && !auth()->user()->role_id != 6) {
                return view('tickets.tickets')->with('data', $data);
            } else {
                return view('tickets.firma-tickets')->with('data', $data);
            }
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function ticketIndex(Request $request, $ticketId)
    {
        try {
            $ticket = Ticket::where('id', $ticketId)->firstOrFail();
            $ticket['lastEdit'] = TicketStatus::where('ticket_id', $ticketId)->orderBy('created_at', 'desc')->first();
            $ticket['attachment'] = TicketAttachment::where('ticket_id', $ticket->id)->get();
            $ticket['discussion'] = Discussion::where('ticket_id', $ticket->id)->orderBy('created_at', 'desc')->get();
            // $ticket['privateDiscussion'] = Discussion::where('ticket_id', $ticket->id)->where('is_private', 1)->get();
            return view('tickets.ticket')->with('ticket', $ticket);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function addTicketIndex(Request $request)
    {
        try {
            $data['status'] = Status::get();
            $data['category'] = Category::orderBy('id', 'DESC')->get();
            $data['goodWill'] = GoodWill::get();

            if (auth()->user()->role_id == 1) {
                return view('tickets.add-ticket', compact('data'));
            }
            if (auth()->user()->role_id == 2) {
                return view('tickets.add-ticket', compact('data'));
            }
            if (auth()->user()->role_id == 3) { //For Personnel Admin
                return view('tickets.add-ticket', compact('data'));
            }
            if (auth()->user()->role_id == 4) { //For Personnel
                return view('tickets.add-ticket-personnel', compact('data'));
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                return view('tickets.add-ticket-firma-admin', compact('data'));
            }
            if (auth()->user()->role_id == 6) { //For Firma User
                return view('tickets.add-ticket-firma-user', compact('data'));
            }
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

            $ticket->coding_time = explode(':', $ticket->coding);
            $ticket->consulting_time = explode(':', $ticket->consulting);
            $ticket->testing_time = explode(':', $ticket->testing);

            $ticket['attachment'] = TicketAttachment::where('ticket_id', $ticket->id)->get();
            $ticket['discussion'] = Discussion::where('ticket_id', $ticket->id)->orderBy('created_at', 'desc')->get();
            if (auth()->user()->role_id == 1) {
                return view('tickets.update-ticket', compact('ticket', 'data'));
            }
            if (auth()->user()->role_id == 2) {
                return view('tickets.update-ticket', compact('ticket', 'data'));
            }
            if (auth()->user()->role_id == 3) { //For Personnel Admin
                return view('tickets.update-ticket', compact('ticket', 'data'));
            }
            if (auth()->user()->role_id == 4) { //For Personnel
                return view('tickets.update-ticket-personnel', compact('ticket', 'data'));
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                return view('tickets.update-ticket', compact('ticket', 'data'));
            }
            if (auth()->user()->role_id == 6) { //For Firma User
                return view('tickets.update-ticket', compact('ticket', 'data'));
            }
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getTickets(Request $request)
    {
        try {
            if (auth()->user()->role_id == 1) {
                if ($request->status == 'all') {
                    $tickets = Ticket::select(['id', 'name', 'org_id', 'personnel', 'user', 'status_id', 'priority', 'due_date', 'category', 'created_at'])->orderBy('id', 'DESC');
                } else {
                    $tickets = Ticket::select(['id', 'name', 'org_id', 'personnel', 'user', 'status_id', 'priority', 'due_date', 'category', 'created_at'])
                        ->where('status_id', $request->status)->orderBy('id', 'DESC');
                }
            }
            if (auth()->user()->role_id == 2) {
                if ($request->status == 'all') {
                    $tickets = Ticket::select(['id', 'name', 'org_id', 'personnel', 'user', 'status_id', 'priority', 'due_date', 'category', 'created_at'])->orderBy('id', 'DESC');
                } else {
                    $tickets = Ticket::select(['id', 'name', 'org_id', 'personnel', 'user', 'status_id', 'priority', 'due_date', 'category', 'created_at'])
                        ->where('status_id', $request->status)->orderBy('id', 'DESC');
                }
            }
            if (auth()->user()->role_id == 3) { //For Personnel Admin
                $users = User::where('personnel', auth()->user()->id);
                $userIds = $users->pluck('id');
                if ($request->status == 'all') {
                    $tickets = Ticket::whereIn('personnel', $userIds)
                        ->orWhere('personnel', auth()->user()->id);
                } else {
                    $tickets = Ticket::where('status_id', $request->status)
                        ->whereIn('personnel', $userIds)
                        ->orWhere('personnel', auth()->user()->id);
                }
            }
            if (auth()->user()->role_id == 4) { //For Personnel
                if ($request->status == 'all') {
                    $tickets = Ticket::where('personnel',  auth()->user()->id);
                } else {
                    $tickets = Ticket::where('status_id', $request->status)->where('personnel',  auth()->user()->id);
                }
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                if ($request->status == 'all') {
                    $tickets = Ticket::where('org_id', auth()->user()->org_id);
                } else {
                    $tickets = Ticket::where('status_id', $request->status)->where('org_id', auth()->user()->org_id);
                }
            }
            if (auth()->user()->role_id == 6) { //For Firma User
                if ($request->status == 'all') {
                    $tickets = Ticket::where('user', auth()->user()->id);
                } else {
                    $tickets = Ticket::where('status_id', $request->status)->where('user', auth()->user()->id);
                }
            }

            $dataTable =  DataTables::of($tickets)
                ->addColumn('actions', function ($tickets) {
                    if (in_array('UPDATE_TICKET', auth()->user()->Permissions) && in_array('DELETE_TICKET', auth()->user()->Permissions))
                        return '<a href="' . url('/update-ticket' . '/' . $tickets->id) . '"><i class="fa fa-pencil btn btn-theme"></i></a>  <a href="#" data-id="' . $tickets->id . '" class="deleteTicket"><i class="fa fa-trash btn btn-danger"></i></a>';
                    if (!in_array('UPDATE_TICKET', auth()->user()->Permissions) && in_array('DELETE_TICKET', auth()->user()->Permissions))
                        return '<a href="#" data-id="' . $tickets->id . '" class="deleteTicket"><i class="fa fa-trash btn btn-danger"></i></a>';
                    if (in_array('UPDATE_TICKET', auth()->user()->Permissions) && !in_array('DELETE_TICKET', auth()->user()->Permissions))
                        return '<a href="' . url('/update-ticket' . '/' . $tickets->id) . '"><i class="fa fa-pencil btn btn-warning"></i></a>';
                    if (!in_array('UPDATE_TICKET', auth()->user()->Permissions) && !in_array('DELETE_TICKET', auth()->user()->Permissions))
                        return '-';
                })->rawColumns(['actions'])
                ->filterColumn(
                    "personnel",
                    function ($q, $k) {
                        $user = User::where('first_name', 'like', '%' . $k . '%')->select('id')->pluck('id');
                        return $q->whereIn('personnel', $user);
                    }
                )
                ->filterColumn(
                    "org_id",
                    function ($q, $k) {
                        $organization = Organization::where('org_name', 'like', '%' . $k . '%')->select('id')->pluck('id');
                        return $q->whereIn('org_id', $organization);
                    }
                )
                ->filterColumn(
                    "category",
                    function ($q, $k) {
                        $category = Category::where('name', 'like', '%' . $k . '%')->select('id')->pluck('id');
                        return $q->whereIn('category', $category);
                    }
                )
                ->filterColumn(
                    "priority",
                    function ($q, $k) {
                        $priority = Priority::where('name', 'like', '%' . $k . '%')->select('id')->pluck('id');
                        return $q->whereIn('priority', $priority);
                    }
                )
                ->toJson();
            return $dataTable;
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function createTicket(Request $request)
    {
        try {
            $rules = array(
                'name' => 'required',
                // 'organization' => 'required',
                // 'user' => 'required',
                // 'personnel' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('add-ticket')->withInput()->withErrors($validator->errors()->all());
            }

            $codingHours = ($request->coding_hours) ? $request->coding_hours : '00';
            $codingMints = ($request->coding_mints) ? $request->coding_mints : '00';
            $codingTime = $codingHours . ':' . $codingMints;

            $consultingHours = ($request->consulting_hours) ? $request->consulting_hours : '00';
            $consultingMints = ($request->consulting_mints) ? $request->consulting_mints : '00';
            $consultingTime = $consultingHours . ':' . $consultingMints;

            $testingHours = ($request->testing_hours) ? $request->testing_hours : '00';
            $testingMints = ($request->testing_mints) ? $request->testing_mints : '00';
            $testingTime = $testingHours . ':' . $testingMints;

            $totalHours = $codingHours + $consultingHours + $testingHours;
            $totalMinutes = $codingMints + $consultingMints + $testingMints;
            if ($totalMinutes >= 60) {
                addHour:
                $totalHours = $totalHours + 1;
                $totalMinutes = $totalMinutes - 60;
                if ($totalMinutes >= 60)
                    goto addHour;
            }
            $totalTime = $totalHours . ':' . $totalMinutes;
            // $totalTime = date("H:i:s", strtotime($codingTime) + strtotime($consultingTime) + strtotime($testingTime));

            $ticket = new Ticket();
            $ticket->name = $request->name;
            $ticket->description = $request->description;
            $ticket->translate = $request->translateToggle ? $request->translate : '';
            $ticket->org_id = ($request->organization) ? $request->organization : auth()->user()->org_id;
            $ticket->user = ($request->user) ? $request->user : 1;
            $ticket->personnel = ($request->personnel) ? $request->personnel : 1;
            $ticket->status_id = ($request->status) ? $request->status : 1;
            $ticket->due_date = ($request->due_date) ? $request->due_date : Carbon::now()->toDateString();
            $ticket->priority = ($request->priority) ? $request->priority : 1;
            $ticket->category = $request->category;
            $ticket->good_will = ($request->good_will) ? $request->good_will : 0;
            $ticket->coding = $codingTime;
            $ticket->consulting =  $consultingTime;
            $ticket->testing =  $testingTime;
            $ticket->total_time = $totalTime;
            $ticket->transport_price = ($request->transport_price) ? $request->transport_price : 0;
            $ticket->add_by = auth()->user()->id;
            $ticket->add_ip = request()->ip();
            $ticket->update_by = auth()->user()->id;
            $ticket->update_ip = request()->ip();
            $ticket->save();

            if ($request->ticketAttachments) {
                foreach ($request->ticketAttachments as $key => $attachment) {
                    $ticketAttachment = new TicketAttachment();
                    $ticketAttachment->ticket_id = $ticket->id;
                    $ticketAttachment->attachment = $attachment;
                    $ticketAttachment->size = $key;
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
                'organization' => 'required',
                'user' => 'required',
                'personnel' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('update-ticket/' . $ticketId)->withInput()->withErrors($validator->errors()->all());
            }

            $codingHours = ($request->coding_hours) ? $request->coding_hours : '00';
            $codingMints = ($request->coding_mints) ? $request->coding_mints : '00';
            $codingTime = $codingHours . ':' . $codingMints;

            $consultingHours = ($request->consulting_hours) ? $request->consulting_hours : '00';
            $consultingMints = ($request->consulting_mints) ? $request->consulting_mints : '00';
            $consultingTime = $consultingHours . ':' . $consultingMints;

            $testingHours = ($request->testing_hours) ? $request->testing_hours : '00';
            $testingMints = ($request->testing_mints) ? $request->testing_mints : '00';
            $testingTime = $testingHours . ':' . $testingMints;

            $totalHours = $codingHours + $consultingHours + $testingHours;
            $totalMinutes = $codingMints + $consultingMints + $testingMints;
            if ($totalMinutes >= 60) {
                addHour:
                $totalHours = $totalHours + 1;
                $totalMinutes = $totalMinutes - 60;
                if ($totalMinutes >= 60)
                    goto addHour;
            }
            $totalTime = $totalHours . ':' . $totalMinutes;

            $ticket = Ticket::where('id', $ticketId)->firstOrFail();
            $ticket->name = ($request->name) ? $request->name : $ticket->name;
            $ticket->description = ($request->description) ? $request->description : $ticket->description;
            $ticket->translate = $request->translateToggle ? $request->translate : '';
            $ticket->org_id = ($request->organization) ? $request->organization : $ticket->org_id;
            $ticket->user = ($request->user) ? $request->user : $ticket->user;
            $ticket->personnel = ($request->personnel) ? $request->personnel : $ticket->personnel;
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
            $ticket->good_will = ($request->good_will) ? $request->good_will : $ticket->good_will;
            $ticket->coding = $codingTime;
            $ticket->consulting =  $consultingTime;
            $ticket->testing =  $testingTime;
            $ticket->total_time = $totalTime;
            $ticket->transport_price = $request->transport_price;
            $ticket->update_by = auth()->user()->id;
            $ticket->update_ip = request()->ip();
            if ($request->ticketAttachments) {
                foreach ($request->ticketAttachments as $key => $attachment) {
                    $ticketAttachment = new TicketAttachment();
                    $ticketAttachment->ticket_id = $ticket->id;
                    $ticketAttachment->attachment = $attachment;
                    $ticketAttachment->size = $key;
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
