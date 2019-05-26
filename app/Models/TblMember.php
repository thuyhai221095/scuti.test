<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblMember extends Model
{
    protected $fillable = ['name', 'infomation', 'phone', 'date_of_birth', 'avatar', 'position'];
    
    public function role()
    {
        return $this->hasMany('App\Models\TblUserRole', 'member_id');
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
        static::deleting(function ($member) {
            $member->role()->delete();
        });
    }
}
