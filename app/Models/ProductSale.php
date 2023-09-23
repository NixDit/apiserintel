<?php

namespace App\Models;

use App\Models\CompanyService;
use App\Models\CompanyCellphone;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSale extends Pivot
{
    protected $table = 'product_sale';
    
    public $timestamps = false;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'subtotal',
        'total',
        'is_recharge',
        'phone',
        'company_id',
        'is_service',
        'no_service',
        'company_service_id'
    ];

    /**
     * Get the company_recharge that owns the ProductSale
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company_recharge()
    {
        return $this->belongsTo(CompanyCellphone::class, 'company_id', 'id');
    }

    /**
     * Get the campany_service that owns the ProductSale
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campany_service()
    {
        return $this->belongsTo(CompanyService::class, 'company_service_id', 'id');
    }

}
