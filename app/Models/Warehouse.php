<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['mateiarl_id', 'in_stock'];

    public $timestamps = false;

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
