<?php

namespace App\Http\Controllers\FirmaAdmin;

use App\Http\Controllers\Controller;
use App\Organization;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            return view('users.users');
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function addUserIndex(Request $request)
    {
        try {
            $roles = Role::get();
            $organizations = Organization::get();
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
            $roles = Role::get();
            $organizations = Organization::get();
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
            $users = User::get();
            return DataTables::of($users)
                ->addColumn('actions', function ($users) {
                    if (in_array('UPDATE_USER', auth()->user()->Permissions) && in_array('DELETE_USER', auth()->user()->Permissions))
                        return '<a href="' . url('/update-user' . '/' . $users->id) . '"><i class="fa fa-pencil btn btn-theme"></i></a> <a href="#" data-id="' . $users->id . '" class="deleteUser"><i class="fa fa-trash btn btn-danger"></i></a>';
                    if (!in_array('UPDATE_USER', auth()->user()->Permissions) && in_array('DELETE_USER', auth()->user()->Permissions))
                        return '<a href="#" data-id="' . $users->id . '" class="deleteUser"><i class="fa fa-trash btn btn-danger"></i></a>';
                    if (in_array('UPDATE_USER', auth()->user()->Permissions) && !in_array('DELETE_USER', auth()->user()->Permissions))
                        return '<a href="' . url('/update-user' . '/' . $users->id) . '"><i class="fa fa-pencil btn btn-theme"></i></a>';
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
                    return '<a href="' . url('/update-user' . '/' . $users->id) . '"><i class="fa fa-pencil btn btn-theme"></i></a> <a href="#" data-id="' . $users->id . '" class="deleteUser"><i class="fa fa-trash btn btn-danger"></i></a>';
                })->rawColumns(['actions'])
                ->make(true);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getOrganizationUsersRawData(Request $request, $organizationId)
    {
        try {
            $users = User::select(['id', 'first_name as text'])->where('org_id', $organizationId)->get();
            return $users;
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getPersonnelRawData(Request $request)
    {
        try {
            $users = User::select(['id', 'first_name as text'])->where('org_id', auth()->user()->org_id)->get();
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
            $user->get_email = 0;
            $user->in_use = 0;
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
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return redirect('add-user')->withInput()->withErrors('User already exists with this email address');
            }

            $user->role_id = $request->role;
            $user->org_id = auth()->user()->org_id;
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
}
