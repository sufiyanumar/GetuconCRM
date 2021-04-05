<?php

namespace App\Http\Controllers\PersonnelAdmin;

use App\Http\Controllers\Controller;
use App\Organization;
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
            $endDate = Carbon::now();
            $startDate = Carbon::now()->firstOfMonth();

            $users = User::where('personnel', auth()->user()->id)->get();
            $userIds = $users->pluck('id');
            $tickets = Ticket::whereIn('personnel', $userIds)->orWhere('personnel', auth()->user()->id)->get();

            $totalTickets = $tickets->count();
            $openTickets = $tickets->where('status_id', 1)->count();
            $totalUsers = $users->count();
            $organization = Organization::get();
            $totalOrganization = $organization->count();
            $data['tickets'] = $tickets;
            $data['totalTickets'] = $totalTickets;
            $data['totalOpenTickets'] = $openTickets;

            $data['recentUsers'] = $users;
            $data['totalUsers'] = $totalUsers;

            $data['totalOrganization'] = $totalOrganization;
            $data['recentOrganizations'] = $organization;
            $data['recentUsers'] = $users;

            return view('index')->with('data', $data);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getGraphData(Request $request)
    {
        try {
            $monthWiseTickets = [];
            
            $users = User::where('personnel', auth()->user()->id)->get();
            $userIds = $users->pluck('id');
            $tickets = Ticket::where('status_id', 1)->whereIn('personnel', $userIds)->orWhere('personnel', auth()->user()->id);

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
