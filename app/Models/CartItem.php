<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;



class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory;

    protected $fillable = ['units', 'user_id', 'product_id', 'product_name', 'product_price', 'bought'];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addToCart($units, $product_name, $product_id, $user_id, $product_price) : self
    {

        return $this::create(['units' => $units, 'product_name' => $product_name, 'product_id' => $product_id, 'user_id' => $user_id, 'product_price' => $product_price]);
    }

    public function getCartItems(): Collection
    {

        return $this::where('user_id', auth()->user()->id)->where('bought', false)->with('product')->get();
    }

    public function getUnitTotal() : int
    {

        return $this::where('user_id', auth()->user()->id)->where('bought', false)->sum('units');
    }

    public function getCartItemByProduct($productId) : ?CartItem
    {
        return $this::where('product_id', $productId)->where('user_id', auth()->user()->id)->where('bought', false)->first();
    }

    public function getSubTotal(): int
    {
        return $this::where('user_id', auth()->user()->id)->where('bought', false)->sum(DB::raw('units * product_price'));
    }

    public function addUnits(int $id) : ?CartItem
    {
        $cartItem = $this::where('id', $id)->where('bought', false)->firstOrFail();
        $cartItem->increment('units');

        return $this::where('id', $id)->where('bought', false)->first();
    }

    public function addUnitsProduct(int $id) : ?CartItem
    {
        $cartItem = $this::where('product_id', $id)->where('bought', false)->firstOrFail();
        $cartItem->increment('units');

        return $this::where('product_id', $id)->where('bought', false)->first();
    }

    public  function lockForUpdateGet() : Collection
    {

        return $this::where('user_id', auth()->user()->id)->where('bought', false)->lockForUpdate()->get();
    }

    public function updateBuyTrue() : bool
    {

        return $this::where('user_id', auth()->id())->where('bought', false)->update(['bought' => true]);

    }
    

    public function subtractUnitsProduct(int $id)
    {
        $cartItem = $this::where('product_id', $id)->where('bought', false)->firstOrFail();
        $cartItem->decrement('units');

        return $this::where('product_id', $id)->where('bought', false)->firstOrFail();
    }

    public function subtractUnits(int $id)
    {
        $cartItem = $this::where('id', $id)->where('bought', false)->firstOrFail();
        $cartItem->decrement('units');

        return $this::where('id', $id)->where('bought', false)->firstOrFail();
    }

    public function removeFromCart(int $id)
    {

        return $this::where('id', $id)->delete();
    }

    public function removeFromCartByProduct(int $id)
    {

        return $this::where('product_id', $id)->where('user_id', auth()->user()->id)->where('bought', false)->delete();
    }

    public function getCartItem(int $id)
    {

        return $this::where('id', $id)->first();
    }

    public function updateUnits($updatedUnits, $id)
    {

        return $this::where('id', '=', $id)->update(['units' => $updatedUnits]);
    }
}
