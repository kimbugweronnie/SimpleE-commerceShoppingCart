<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory,HasSlug;

    protected $fillable = ['name', 'price', 'stock_quantity'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs(false)
            ->slugsShouldBeNoLongerThan(50);
    }

    public function cartItems() : HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getProduct(int $productId) : ?Product
    {
        return $this::where('id', $productId)->first();
    }

    public function lockForUpdateProduct($item) : ?Product
    {
        $product = $this::where('id', $item->product_id)->lockForUpdate()->first();
        return $product;
        // $product->decrement('stock_quantity', $item->units);

    }

}
