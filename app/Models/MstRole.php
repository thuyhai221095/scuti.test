<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstRole extends Model
{
    static public function allToOption()
    {
        $position = MstRole::all();
        $array = [];
        foreach ($position as $row) {
            $array[] = [
                'name' => $row->name,
                'value' => $row->value
            ];
        }
        return $array;
    }
}
