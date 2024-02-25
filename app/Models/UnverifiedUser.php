<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnverifiedUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'email_verify_code'
    ];
}
