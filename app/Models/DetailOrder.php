<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function products()
    {
        return $this->belongsTo(Product::class, "id_product");
    }

    public function signas()
    {
        return $this->belongsTo(Signa::class, "id_signa");
    }
}
