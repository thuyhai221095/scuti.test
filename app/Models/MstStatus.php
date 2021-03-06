<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstStatus extends Model
{
    public static function allToOption()
    {
        $position = MstStatus::all();
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
