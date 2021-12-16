<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordPhoto extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        "path" ,
        "records_id"  ,
    ];
}
