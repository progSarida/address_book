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

    protected static function booted()
    {
        static::creating(function ($contact) {
            $contact->company = 'sarida';
        });

        static::saving(function ($contact) {
            $contact->name = $contact->name ? $contact->name : '';
        });

        static::deleted(function ($contact) {
            $contact->referents()->delete();
        });
    }
}
