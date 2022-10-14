<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'needs' => 'array',
    ];

    public function cost_shops()
    {
        return $this->hasMany(CostShopDetail::class);
    }
    
    public function transaction_detail_items()
    {
        return $this->hasMany(TransactionDetailItem::class);
    }
}
