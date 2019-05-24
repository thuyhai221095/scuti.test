<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstType extends Model
{
    static public function allToOption()
    {
        $position = MstType::all();
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
