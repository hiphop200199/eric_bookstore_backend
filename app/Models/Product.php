<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;


    public static function getList()
   {
    return DB::select('CALL Product_SP_GetPopularList()');
   }
}
