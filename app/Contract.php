<?php

namespace Accordous;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'property_id',
        'name',
        'email',
        'document_type',
        'document_number'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
