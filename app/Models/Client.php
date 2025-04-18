<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
        'name',
        'email',
        'cpf',
        'phone',
    ];

    protected $casts = [
        'cpf' => 'string',
    ];

    protected $table = 'clients';

    protected $primaryKey = 'id';
}
