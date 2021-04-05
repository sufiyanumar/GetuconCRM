<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getorganizationNameAttribute()
    {
        try {
            $organization = Organization::where('id', $this->org_id)->first();
            if ($organization)
                return $organization->org_name;
        } catch (Exception $e) {
            return '';
        }
    }
    public function getroleNameAttribute()
    {
        try {
            $role = Role::where('id', $this->role_id)->first();
            if ($role)
                return $role->name;
        } catch (Exception $e) {
            return '';
        }
    }
    public function getPermissionsAttribute()
    {
        try {
            $rolePermissions = RolePermission::where('role_id', $this->role_id)->get();
            $rolePermissions = $rolePermissions->pluck('permission')->toArray();
            return $rolePermissions;
        } catch (Exception $e) {
            return '';
        }
    }
    protected $appends = ['organizationName', 'roleName', 'Permissions'];
}
