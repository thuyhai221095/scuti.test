<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblProject extends Model
{
    protected $fillable = ['name', 'infomation', 'type', 'status', 'deadline'];

    public function users()
    {
        return $this->belongsToMany('App\Models\TblMember', "tbl_user_roles", "project_id", "member_id");
    }

    public function role()
    {
        return $this->hasMany('App\Models\TblUserRole', 'project_id');
    }

    public static function getStatus()
    {
        return [
            ['name' => 'Planned', 'value' => 'planned'],
            ['name' => 'Onhold', 'value' => 'onhold'],
            ['name' => 'Doing', 'value' => 'doing'],
            ['name' => 'Done', 'value' => 'done'],
            ['name' => 'Cancelled', 'value' => 'cancelled'],
        ];
    }
    
    public static function getType()
    {
        return [
            ['name' => 'Lab', 'value' => 'lab'],
            ['name' => 'Single', 'value' => 'single'],
            ['name' => 'Acceptance', 'value' => 'acceptance']
        ];
    }
    
    public static function filterInput($query, $key_in_request, $key_in_db, $request)
    {
        if (isset($request->{$key_in_request}) && !empty($request->{$key_in_request})) {
            $data_request = $request->{$key_in_request};
            $query = $query->where($key_in_db, 'LIKE', '%'.$data_request.'%');
        }
        return $query;
    }

    public static function filterDate($query, $key_in_request, $key_in_db, $request)
    {
        
        if (isset($request->{$key_in_request}) && !empty($request->{$key_in_request})) {
            $date = date('Y-m-d', strtotime($request->{$key_in_request}));
            $query = $query->where($key_in_db, $date);
        }
        return $query;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($project) {
            $project->role()->delete();
        });
    }
}
