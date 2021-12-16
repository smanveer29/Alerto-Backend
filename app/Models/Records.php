<?php

namespace App\Models;

use App\Models\RecordPhoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Records extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'location','latitude','longitude','pincode','title'
    ];

    // public function photos()
    // {
    //     return $this->hasMany(RecordPhoto::class);
    // }
}
