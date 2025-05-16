<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referent extends Model
{
    protected $fillable = [
        'name',
        'title',
        'phone',
        'fax',
        'smart',
        'email',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
