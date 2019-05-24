<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstPosition extends Model
{
    static public function allToOption()
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
