<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'title',
        'surname',
        'name',
        'toponym',
        'addr',
        'num',
        'apart',
        'city',
        'cap',
        'province',
        'phone_1',
        'phone_2',
        'fax',
        'smart_1',
        'smart_2',
        'email_1',
        'email_2',
        'site',
        'note',
    ];

    public function referents()
    {
        return $this->hasMany(Referent::class);
    }
}
