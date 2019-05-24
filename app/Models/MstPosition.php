<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstPosition extends Model
{
    public static function allToOption()
    {
        $position = MstPosition::all();
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
