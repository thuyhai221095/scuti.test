<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblUserRole extends Model
{
    public function member()
    {
        return $this->belongsTo("App\Models\TblMember", "member_id");
    }
}
