<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class OrganizationController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            if (!in_array('VIEW_ORGANIZATIONS', auth()->user()->Permissions)) {
                return redirect('/dashboard');
            }
            $success = [];
            return view('organizations.organizations', compact('success'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function addOrganizationIndex(Request $request)
    {
        try {
            return view('organizations.add-organization');
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getOrganizationsRawData(Request $request)
    {
        try {
            if (auth()->user()->role_id == 1) {
                $organizations = Organization::select(['id', 'org_name as text'])->where('org_name', 'like', '%' . $request->q . '%')->get();
            }
            if (auth()->user()->role_id == 2) {
                $organizations = Organization::select(['id', 'org_name as text'])->where('org_name', 'like', '%' . $request->q . '%')->get();
            }
            if (auth()->user()->role_id == 3) { //For Personnel Admin
                $users = User::where('personnel', auth()->user()->id)->get();
                $userIds = $users->pluck('id');
                $tickets = Ticket::where('status_id', $request->status)
                    ->whereIn('personnel', $userIds)
                    ->orWhere('personnel', auth()->user()->id)
                    ->get();
                $orgId = $tickets->pluck('org_id');
                $organizations = Organization::select(['id', 'org_name as text'])->whereIn('id', $orgId)->where('org_name', 'like', '%' . $request->q . '%')->get();
            }
            if (auth()->user()->role_id == 4) { //For Personnel
                $tickets = Ticket::where('status_id', $request->status)->where('personnel',  auth()->user()->id)->get();
                $orgId = $tickets->pluck('org_id');
                $organizations = Organization::select(['id', 'org_name as text'])->whereIn('id', $orgId)->where('org_name', 'like', '%' . $request->q . '%')->get();
            }
            if (auth()->user()->role_id == 5) { //For Firma Admin
                $organizations = Organization::select(['id', 'org_name as text'])->where('id', auth()->user()->org_id)->get();
            }
            if (auth()->user()->role_id == 6) { //For Firma User
                $organizations = Organization::select(['id', 'org_name as text'])->where('id', auth()->user()->org_id)->get();
            }
            return $organizations;
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function organizationIndex(Request $request, $id)
    {
        try {
            $organization = Organization::where('id', $id)->first();
            return view('organizations.organization', compact('organization'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getOrganization(Request $request, $id)
    {
        try {
            $organization = Organization::where('id', $id)->first();
            return $organization;
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function updateOrganizationIndex(Request $request, $id)
    {
        try {
            $organization = Organization::where('id', $id)->first();
            return view('organizations.update-organization', compact('organization'));
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function getOrganizations(Request $request)
    {
        try {
            $organizations = Organization::get();
            return DataTables::of($organizations)
                ->addColumn('actions', function ($organizations) {
                    if ($organizations->is_active == 1) {
                        $title = 'Active';
                        $icon = 'fe fe-user-check';
                        $status = 0;
                    } else {
                        $title = 'Inactive';
                        $icon = 'fe fe-user-x';
                        $status = 1;
                    }
                    if (in_array('UPDATE_ORGANIZATION', auth()->user()->Permissions) && in_array('DELETE_ORGANIZATION', auth()->user()->Permissions))
                        return '<a href="' . url('/update-organization' . '/' . $organizations->id) . '"><i class="fa fa-pencil btn btn-theme"></i></a> <a href="#" data-id="' . $organizations->id . '" class="deleteOrganization"><i class="fa fa-trash btn btn-danger"></i></a> <a href="#" data-id="' . $organizations->id . '" data-status="' . $status . '" class="updateStatus"><i class="' . $icon . ' btn btn-info" data-toggle="tooltip" data-original-title="' . $title . '"></i></a';
                    if (!in_array('UPDATE_ORGANIZATION', auth()->user()->Permissions) && in_array('DELETE_ORGANIZATION', auth()->user()->Permissions))
                        return '<a href="#" data-id="' . $organizations->id . '" class="deleteOrganization"><i class="fa fa-trash btn btn-danger"></i></a>';
                    if (in_array('UPDATE_ORGANIZATION', auth()->user()->Permissions) && !in_array('DELETE_ORGANIZATION', auth()->user()->Permissions))
                        return '<a href="' . url('/update-organization' . '/' . $organizations->id) . '"><i class="fa fa-pencil btn btn-warning"></i></a>';
                    if (!in_array('UPDATE_ORGANIZATION', auth()->user()->Permissions) && !in_array('DELETE_ORGANIZATION', auth()->user()->Permissions))
                        return '';
                })
                ->addColumn('profile_picture', function ($organizations) {
                    if ($organizations->picture)
                        return '<img src="' . asset('/storage/uploadsnew/OrgImage/') . '/' . $organizations->picture . '" alt="img">';
                    else
                        return '<img src="https://ui-avatars.com/api/?name=' . $organizations->org_name . '&background=5E72E4&color=fff&size=400" alt="img">';
                })
                ->addColumn('rating_flag', function ($organizations) {
                    $color = 'success';
                    $text = '';
                    if ($organizations->rating == 1 || !$organizations->rating) {
                        $color = 'danger';
                        $text = 'Blacklist Client';
                    }
                    if ($organizations->rating == 2) {
                        $color = 'warning';
                        $text = 'Normal Client';
                    }
                    if ($organizations->rating == 3) {
                        $color = 'success';
                        $text = 'Good Client';
                    }
                    return '<div class="text-center"><i class="fa fa-flag btn btn-' . $color . '" ></i><span style="display:none; ">' . $text . '</span></div>';
                })->rawColumns(['profile_picture', 'actions', 'rating_flag'])
                ->make(true);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function createOrganization(Request $request)
    {
        try {
            $rules = array(
                'name' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('add-organization')->withInput()->withErrors($validator->errors()->all());
            }
            $organization = new Organization();
            $organization->org_name = $request->name;
            $organization->phone_no = $request->phone;
            $organization->email = $request->email;
            $organization->gsm = $request->gsm;
            $organization->address = $request->address;
            $organization->city = $request->city;
            $organization->zip_code = $request->zip_code;
            $organization->contract = $request->contract;
            $organization->contract_frequency = $request->frequency;
            $organization->contract_start_date = $request->start_date;
            $organization->contract_end_date = $request->end_date;
            $organization->price = $request->price;
            $organization->price_monthly = $request->price_monthly;
            $organization->rating = $request->rating;
            $organization->transport_price = $request->transport_price;

            //for Logo
            if ($request->hasfile('logo')) {
                $file = $request->file('logo');
                $fileOriginalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileOriginalName . '_' . time() . '.' . $extension;
                $filename = $file->storeAs('public/uploadsnew/OrgImage', $fileNameToStore);
                $organization->picture = $fileNameToStore;
            }



            $organization->add_by = auth()->user()->id;
            $organization->add_ip = request()->ip();
            $organization->update_by = auth()->user()->id;
            $organization->update_ip = request()->ip();
            $organization->save();
            return redirect('organization/' . $organization->id);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function editOrganization(Request $request, $id)
    {
        try {
            $rules = array(
                'name' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('update-organization')->withInput()->withErrors($validator->errors()->all());
            }
            $organization = Organization::where('id', $id)->first();
            $organization->org_name = $request->name;
            $organization->phone_no = $request->phone;
            $organization->email = $request->email;
            $organization->gsm = $request->gsm;
            $organization->address = $request->address;
            $organization->city = $request->city;
            $organization->zip_code = $request->zip_code;
            $organization->contract = $request->contract;
            $organization->contract_frequency = $request->frequency;
            $organization->rating = $request->rating;
            $organization->contract_start_date = $request->start_date;
            $organization->contract_end_date = $request->end_date;
            $organization->price = $request->price;
            $organization->price_monthly = $request->price_monthly;
            $organization->transport_price = $request->transport_price;

            //for Logo
            if ($request->hasfile('logo')) {
                $file = $request->file('logo');
                $fileOriginalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileOriginalName . '_' . time() . '.' . $extension;
                $filename = $file->storeAs('public/uploadsnew/OrgImage', $fileNameToStore);
                $organization->picture = $fileNameToStore;
            }

            $organization->update_by = auth()->user()->id;
            $organization->update_ip = request()->ip();
            $organization->save();
            return redirect('organization/' . $organization->id);
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function deleteOrganization(Request $request, $id)
    {
        try {
            $success = '';
            $organization = Organization::where('id', $id)->first();
            $users = User::where('org_id', $organization->id)->get();
            if ($users->count()) {
                foreach ($users as $user) {
                    $user->delete();
                }
            }
            $organization->delete();
            $success = 'Organization deleted successfully';
            return $success;
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
    public function updateOrganizationStatus(Request $request, $id)
    {
        try {
            $isActive = ($request->status) ? 1 : 0;
            $message = ($request->status) ? 'active' : 'in-active';
            $organization = Organization::where('id', $id)->first();
            $organization->is_active = $isActive;
            $organization->save();
            return ['success' => 'Organization marked ' . $message];
        } catch (Exception $e) {
            return ['error' => 'Something went wrong'];
        }
    }
}
