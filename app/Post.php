<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// Napravili smo model koji je objekat jedne tabele
class Post extends Model
{
    // Table name
    protected $table = 'posts';
    // Primary key
    public $primarykey = 'id';
    // Time stamps
    public $timestamps = true;

    public function user() {
        // Post ima vezu sa korisnikom i pripada korisniku
        return $this->belongsTo('App\User');
    }
}

