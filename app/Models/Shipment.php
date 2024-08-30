<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tokenId',
        'artName',
        'price',
        'owner',
        'address',
        'postalCode',
        'deliveryNumber',
        'status',
        'withdraw',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
