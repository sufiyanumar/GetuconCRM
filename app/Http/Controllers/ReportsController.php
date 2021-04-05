<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Ticket;
use App\TicketAttachment;
use App\TicketStatus;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PDFS;

class ReportsController extends Controller
{
    //
    public function index()
    {
        try {
            return view('reports.reports');
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getTicketSummary(Request $request)
    {
        try {
            $returnType = $request->returnType;
            $user = User::where('id', $request->user)->first();
            if ($user) {
                if ($user->role_id == 3 || $user->role_id == 4)
                    $tickets = Ticket::where('personnel', $request->user)->get();
                else
                    $tickets = Ticket::where('user', $request->user)->get();
            } else
                $tickets = Ticket::get();
            foreach ($tickets as $index => $ticket) {
                $ticketStatus = TicketStatus::where('ticket_id', $ticket->id)->get();
                $tickets[$index]['status'] = $ticketStatus;
                $ticketAAttachments = TicketAttachment::where('ticket_id', $ticket->id)->get();
                $tickets[$index]['attachments'] = $ticketAAttachments;
            }

            if ($returnType == 'pdf') {
                $data['tickets'] = $tickets;
                $pdf = PDFS::loadView('reports.ticket-summary', $data);
                return $pdf->inline('ticket-summary.pdf');
            } else
                return view('reports.ticket-summary')->with('tickets', $tickets);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getOrganizationSummary(Request $request)
    {
        try {
            $returnType = $request->returnType;
            if (auth()->user()->role_id == 1) {
                $organizations = Organization::get();
                foreach ($organizations as $index => $organization) {
                    $organizations[$index]['tickets'] = Ticket::where('org_id', $organization->id)->get();
                }
            } else {
                $organizations = Organization::get();
                foreach ($organizations as $index => $organization) {
                    $organizations[$index]['tickets'] = Ticket::where('org_id', $organization->id)->get();
                }
            }
            if ($returnType == 'pdf') {
                $data['organizations'] = $organizations;
                $pdf = PDFS::loadView('reports.organization-summary', $data);
                return $pdf->inline('organization-summary.pdf');
            } else
                return view('reports.organization-summary')->with('organizations', $organizations);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getUsersRawData(Request $request)
    {
        try {
            $users = User::select(['id', 'first_name as text'])->get();
            return $users;
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
}
