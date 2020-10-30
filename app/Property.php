<?php

namespace Accordous;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'email',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state'
    ];

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}
