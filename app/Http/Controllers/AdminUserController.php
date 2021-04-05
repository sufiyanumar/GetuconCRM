<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            if (!in_array('VIEW_USERS', auth()->user()->Permissions)) {
                return redirect('/dashboard');
            }
            return view('users.users');
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function addUserIndex(Request $request)
    {
        try {
            $roles = Role::where('id', '>=', auth()->user()->role_id)->get();
            if (auth()->user()->role_id == 1) {
                $organizations = Organization::get();
            }
            if (auth()->user()->role_id == 2) {
                $tickets = Ticket::where('status_id', $request->status)->get();
            }
            if (auth()->user()->role_id == 3) { //For Personnel Admin
                $users = User::where('personnel', auth()->user()->id)->get();
                $userIds = $users->pluck('id');
                $tickets = Ticket::where('status_id', $request->status)
                    ->whereIn('personnel', $userIds)
                    ->orWhere('personnel', auth()->user()->id)
                    ->get();
                $orgId = $tickets->pluck('org_id');
                $organizations = Organization::whereIn('id', $orgId)->get();
            }
            if (auth()->user()->role_id == 4) { //For Personnel
                $tickets = Ticket::where('status_id', $request->status)->where('personnel',  auth()->user()->id)->get();
                $orgId = $tickets->pluck('org_id');
                $organizations = Organization::whereIn('id', $orgId)->get();
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                $organizations = Organization::where('id', auth()->user()->org_id)->get();
            }
            if (auth()->user()->role_id == 6) { //For Firma User
                $organizations = Organization::whereIn('id', auth()->user()->org_id)->get();
            }
            return view('users.add-user', compact('roles', 'organizations'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function userIndex(Request $request, $id)
    {
        try {
            $message = '';
            $user = User::where('id', $id)->first();
            return view('users.user', compact('user', 'message'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function updateUserIndex(Request $request, $id)
    {
        try {
            $roles = Role::where('id', '>=', auth()->user()->role_id)->get();
            if (auth()->user()->role_id == 1) {
                $organizations = Organization::get();
            }
            if (auth()->user()->role_id == 2) {
                $tickets = Ticket::where('status_id', $request->status)->get();
            }
            if (auth()->user()->role_id == 3) { //For Personnel Admin
                $users = User::where('personnel', auth()->user()->id)->get();
                $userIds = $users->pluck('id');
                $tickets = Ticket::where('status_id', $request->status)
                    ->whereIn('personnel', $userIds)
                    ->orWhere('personnel', auth()->user()->id)
                    ->get();
                $orgId = $tickets->pluck('org_id');
                $organizations = Organization::whereIn('id', $orgId)->get();
            }
            if (auth()->user()->role_id == 4) { //For Personnel
                $tickets = Ticket::where('status_id', $request->status)->where('personnel',  auth()->user()->id)->get();
                $orgId = $tickets->pluck('org_id');
                $organizations = Organization::whereIn('id', $orgId)->get();
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                $organizations = Organization::where('id', auth()->user()->org_id)->get();
            }
            if (auth()->user()->role_id == 6) { //For Firma User
                $organizations = Organization::whereIn('id', auth()->user()->org_id)->get();
            }
            $user = User::where('id', $id)->first();
            return view('users.update-user', compact('user', 'roles', 'organizations'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getUser(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->first();
            return $user;
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getUsers(Request $request)
    {
        try {
            if (auth()->user()->role_id == 1) {
                $users = User::get();
            }
            if (auth()->user()->role_id == 2) {
                $users = User::get();
            }
            if (auth()->user()->role_id == 3) { //For Personnel Admin
                $users = User::where('personnel', auth()->user()->id)->get();
            }
            if (auth()->user()->role_id == 4) { //For Personnel
                $users = User::where('id', auth()->user()->id)->get();
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                $users = User::where('org_id', auth()->user()->org_id)->get();
            }
            if (auth()->user()->role_id == 6) { //For Firma User
                $users = User::where('id', auth()->user()->id)->get();
            }
            return DataTables::of($users)
                ->addColumn('actions', function ($users) {
                    if ($users->in_use == 1) {
                        $title = 'Active';
                        $icon = 'fe fe-user-check';
                        $status = 0;
                    } else {
                        $title = 'Inactive';
                        $icon = 'fe fe-user-x';
                        $status = 1;
                    }
                    if (in_array('UPDATE_USER', auth()->user()->Permissions) && in_array('DELETE_USER', auth()->user()->Permissions))
                        return '<a href="' . url('/update-user' . '/' . $users->id) . '"><i class="fa fa-pencil btn btn-theme"></i></a> <a href="#" data-id="' . $users->id . '" class="deleteUser"><i class="fa fa-trash btn btn-danger"></i></a>  <a href="#" data-id="' . $users->id . '" data-status="' . $status . '" class="userStatus"><i class="' . $icon . ' btn btn-info" data-toggle="tooltip" data-original-title="' . $title . '"></i></a>';
                    if (!in_array('UPDATE_USER', auth()->user()->Permissions) && in_array('DELETE_USER', auth()->user()->Permissions))
                        return '<a href="#" data-id="' . $users->id . '" class="deleteUser"><i class="fa fa-trash btn btn-danger"></i></a>';
                    if (in_array('UPDATE_USER', auth()->user()->Permissions) && !in_array('DELETE_USER', auth()->user()->Permissions))
                        return '<a href="' . url('/update-user' . '/' . $users->id) . '"><i class="fa fa-pencil btn btn-theme"></i></a> <a href="#" data-id="' . $users->id . '" class="userStatus"><i class="' . $icon . ' btn btn-info" data-toggle="tooltip" data-original-title="' . $title . '"></i></a><span style="display:none;">' . $title . '</span>';
                    if (!in_array('UPDATE_USER', auth()->user()->Permissions) && !in_array('DELETE_USER', auth()->user()->Permissions))
                        return '-';
                })->rawColumns(['actions'])
                ->make(true);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getOrganizationUsers(Request $request, $organizationId)
    {
        try {
            $users = User::where('org_id', $organizationId)->get();
            return DataTables::of($users)
                ->addColumn('actions', function ($users) {
                    return '<a href="' . url('/update-user' . '/' . $users->id) . '"><i class="fa fa-pencil btn btn-theme"></i></a>  <a href="#" data-id="' . $users->id . '" class="deleteUser"><i class="fa fa-trash btn btn-danger"></i></a>';
                })->rawColumns(['actions'])
                ->make(true);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getOrganizationUsersRawData(Request $request, $organizationId)
    {
        try {
            $users = User::select(['id', DB::raw("CONCAT(first_name,' ',surname)as text")])->where('org_id', $organizationId)->where('first_name', 'like', '%' . $request->q . '%')->get();
            return $users;
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getPersonnelRawData(Request $request)
    {
        try {
            $users = User::select(['id', DB::raw("CONCAT(first_name,' ',surname)as text")])->where('first_name', 'like', '%' . $request->q . '%')->whereIn('role_id', [4, 1])->get();
            return $users;
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function createUser(Request $request)
    {
        try {
            $rules = array(
                'role' => 'required',
                'organization' => 'required',
                'first_name' => 'required',
                'email' => 'required',
                'password' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('add-user')->withInput()->withErrors($validator->errors()->all());
            }
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return redirect('add-user')->withInput()->withErrors('User already exists with this email address');
            }
            if ($request->password != $request->confirm_password) {
                return redirect('add-user')->withInput()->withErrors('Password does not match');
            }
            $user = new User();
            $user->role_id = $request->role;
            $user->org_id = $request->organization;
            $user->first_name = $request->first_name;
            $user->surname = $request->last_name;
            $user->phone_no = $request->phone;
            $user->email = $request->email;
            $user->get_email = 1;
            $user->in_use = 1;
            $user->last_login = Carbon::now();
            $user->add_by = auth()->user()->id;
            $user->add_ip = request()->ip();
            $user->ip = request()->ip();
            $user->update_by = auth()->user()->id;
            $user->update_ip = request()->ip();
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect('user/' . $user->id);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function editUser(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->first();

            $rules = array(
                'role' => 'required',
                'organization' => 'required',
                'first_name' => 'required',
                'email' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('add-user')->withInput()->withErrors($validator->errors()->all());
            }
            $checkUser = User::where('email', $request->email)->where('id', '!=', $id)->first();
            if ($checkUser) {
                return redirect('add-user')->withInput()->withErrors('User already exists with this email address');
            }

            $user->role_id = $request->role;
            $user->org_id = $request->organization;
            $user->first_name = $request->first_name;
            $user->surname = $request->last_name;
            $user->phone_no = $request->phone;
            $user->email = $request->email;
            $user->update_by = auth()->user()->id;
            $user->update_ip = request()->ip();
            $user->save();
            $message = 'User updated successfully';
            return redirect('user/' . $user->id)->with($message);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function deleteUser(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->first();
            $user->delete();
            $message = 'User deleted successfully';
            return redirect('/users')->with($message);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function updateUserStatus(Request $request, $userId)
    {
        try {
            $isActive = ($request->status) ? 1 : 0;
            $message = ($request->status) ? 'active' : 'in-active';
            $user = User::where('id', $userId)->first();
            $user->in_use = $isActive;
            $user->save();
            return ['success' => 'User marked ' . $message];
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function updateEmailStatus(Request $request, $userId)
    {
        try {
            $isEmail = ($request->status) ? 1 : 0;
            $message = ($request->status) ? 'active' : 'in-active';
            $user = User::where('id', $userId)->first();
            $user->get_email = $isEmail;
            $user->save();
            return ['success' => 'User emails marked ' . $message];
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function resetUserPassword(Request $request, $userId)
    {
        try {
            if ($request->new_password != $request->confirm_password) {
                return ['error' => 'Password does not match'];
            }
            $user = User::where('id', $userId)->first();
            $user->password =  Hash::make($request->new_password);
            $user->save();
            return ['success' => 'Password reset successfully'];
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function loginFromUser(Request $request, $userId)
    {
        try {
            $user = User::where('id', $userId)->first();
            Auth::login($user);
            return redirect('/dashboard');
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
}
