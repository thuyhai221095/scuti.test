<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblUserRole extends Model
{
    protected $fillable = ['project_id', 'member_id', 'role'];

    public function member()
    {
        return $this->belongsTo("App\Models\TblMember", "member_id");
    }

    public function project()
    {
        return $this->belongsTo("App\Models\TblProject", "project_id");
    }
}
