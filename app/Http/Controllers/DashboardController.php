<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Status;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function getDashboard(Request $request)
    {
        try {
            $tickets = '';
            $totalTickets = 0;

            $transferedTickets = 0;
            $inProgressTickets = 0;
            $answeredTickets = 0;
            $queryTickets = 0;
            $doneTickets = 0;
            $invoicedTickets = 0;
            $onHoldTickets = 0;
            $closedTickets = 0;

            $openTickets = 0;
            $users = '';
            $totalUsers = 0;
            $totalOrganization = 0;
            $organization = '';

            $endDate = Carbon::now();
            $startDate = Carbon::now()->firstOfMonth();
            $status = Status::get();
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


                $users = User::get();
                $totalUsers = $users->count();
                $organization = Organization::get();
                $totalOrganization = $organization->count();
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
                $users = User::get();
                $totalUsers = $users->count();
                $organization = Organization::get();
                $totalOrganization = $organization->count();
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
                $totalUsers = $users->count();
                $organization = Organization::get();
                $totalOrganization = $organization->count();
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
                $totalUsers = $users->count();
                $organization = Organization::get();
                $totalOrganization = $organization->count();
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                $users = User::where('personnel', auth()->user()->id)->get();
                $userIds = $users->pluck('id');
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
                $totalUsers = $users->count();
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
                $totalUsers = $users->count();
            }

            $data['tickets'] = $tickets;
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

            $data['recentUsers'] = $users;
            $data['totalUsers'] = $totalUsers;

            $data['totalOrganization'] = $totalOrganization;
            $data['recentOrganizations'] = $organization;

            $data['status'] = $status;


            return view('index')->with('data', $data);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getGraphData(Request $request)
    {
        try {
            $monthWiseTickets = [];
            if (auth()->user()->role_id == 1) {
                $tickets = Ticket::where('status_id', 1);
            }
            if (auth()->user()->role_id == 2) {
                $tickets = Ticket::where('status_id', 1);
            }
            if (auth()->user()->role_id == 3) { //For Personnel Admin
                $users = User::where('personnel', auth()->user()->id)->get();
                $userIds = $users->pluck('id');
                $tickets = Ticket::where('status_id', 1)
                    ->whereIn('personnel', $userIds)
                    ->orWhere('personnel', auth()->user()->id);
            }
            if (auth()->user()->role_id == 4) { //For Personnel
                $tickets = Ticket::where('status_id', 1)->where('personnel',  auth()->user()->id);
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                $tickets = Ticket::where('status_id', 1)->where('org_id', auth()->user()->org_id);
            }
            if (auth()->user()->role_id == 6) { //For Firma User
                $tickets = Ticket::where('status_id', 1)->where('user', auth()->user()->id);
            }
            // if (auth()->user()->role_id == 1)
            //     $tickets = Ticket::where('status_id', 1);
            // else
            //     $tickets = Ticket::where('status_id', 1);
            if ($request->timeLine == 'monthly') {
                $fromMonth = (Carbon::now())->startOfMonth()->subMonths(11);
                $toMonth = Carbon::now()->startOfMonth();
                $monthArray = $this->initMonths($fromMonth, $toMonth);
                foreach ($monthArray as $month) {
                    $ticketRow = clone $tickets;
                    $ticketRow = $ticketRow->where(DB::raw('MONTH(created_at)'), $month->month)->where(DB::raw('YEAR(created_at)'), $month->year);
                    $formateMonth = $month->format('M y');
                    $monthWiseTickets[$formateMonth] = round($ticketRow->count());
                }
                return $monthWiseTickets;
            } else {
                $fromWeek = (Carbon::now())->endOfWeek()->subWeeks(11);
                $toWeek = (Carbon::now())->endOfWeek();
                $weekArray = $this->initWeeks($fromWeek, $toWeek);
                $lastValue = end($weekArray);
                foreach ($weekArray as $index => $week) {
                    $startDate = $week->format('Y-m-d');
                    if ($week != $lastValue)
                        $endDate = $weekArray[$index + 1]->format('Y-m-d');
                    else
                        $endDate = $week->copy()->endOfWeek()->format('Y-m-d');
                    $ticketRow = clone $tickets;
                    $ticketRow = $ticketRow->where(DB::raw('date(created_at)'), '>', $startDate)->where(DB::raw('date(created_at)'), '<=', $endDate);
                    $beautifiedWeek = $week->format('d-m-y');
                    $weekWiseTickets[$beautifiedWeek] = round($ticketRow->count());
                }
                return $weekWiseTickets;
            }
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }

    public function initMonths($from, $to)
    {
        $period = CarbonPeriod::create($from, '1 month', $to);
        $periodArray = [];
        foreach ($period as $carbonObj) {
            $periodArray[] = $carbonObj;
        }
        return $periodArray;
    }

    public function initWeeks($from, $to)
    {
        $period = CarbonPeriod::create($from, '1 week', $to);
        $periodArray = [];
        foreach ($period as $carbonObj) {
            $periodArray[] = $carbonObj;
        }
        return $periodArray;
    }
}
