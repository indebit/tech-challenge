<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $appends = [
        'url',
    ];

    protected $fillable = [
        'date',
        'description',
    ];

    protected $dates = [
        'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getUrlAttribute()
    {
        return "/clients/" . $this->client_id;
    }
}
