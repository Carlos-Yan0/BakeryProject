<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['product_code', 'name', 'description', 'stock', 'price', 'active', 'category_id'])]
class Product extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return
        [
            'stock' => 'integer',
            'price' => 'decimal:2',
            'active' => 'boolean',
        ];
    }
}
