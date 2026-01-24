<?php
namespace App\Services;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Jobs\LowStockNotification;
use App\Services\ActionLogService;

class CartService extends Controller
{
    private $cartItem;
    private $product;
    
    public function __construct(CartItem $cartItem,Product $product) {
        $this->cartItem = $cartItem;
        $this->product = $product;
    }

    public function getCartItems(){

        return  $this->cartItem->getCartItems();
    }

    public function getCartItem($id){

        return  $this->cartItem->getCartItem($id);
    }

    public function getCartItemByProduct($id){

        return  $this->cartItem->getCartItemByProduct($id);
    }

    public function getProduct(int $productId){

        return $this->cartItem->getProduct($productId);
    }

    public function getUnitTotal(){

        return $this->cartItem->getUnitTotal();
    }

    public function getSubTotal(){

        return $this->cartItem->getSubTotal();

    }

    //removing cart Item
    public function removeFromCart($id,ActionLogService $logger){
        $cartItem = $this->cartItem->getCartItem($id);
        $logger->log(
                auth()->user()->id,
                'removed item from cart',
                CartItem::class,
                $cartItem->id,
                ['action' => auth()->user()->name . ' removed ' . $cartItem->product_name . ' from cart at ' .$cartItem->updated_at->format('Y-m-d H:i:s')]
            );

        $this->cartItem->removeFromCart($id);
    }

    //Remove cart by product
    public function removeFromCartByProduct($id,ActionLogService $logger){
        $cartItem = $this->cartItem->getCartItemByProduct($id);
        $logger->log(
                auth()->user()->id,
                'removed item from cart',
                CartItem::class,
                $cartItem->id,
                ['action' => auth()->user()->name . ' removed ' . $cartItem->product_name . ' from cart at ' .$cartItem->updated_at->format('Y-m-d H:i:s')]
            );

        $this->cartItem->removeFromCartByProduct($id);
    }
    //adding units 
    public function addUnits(int $id,ActionLogService $logger){
        $cartItem = $this->cartItem->addUnits($id);
        $logger->log(
            auth()->user()->id,
            'add extra units',
            CartItem::class,
            $cartItem->id,
            ['action' => auth()->user()->name . ' increased  the units of ' . $cartItem->product_name . ' to  ' .$cartItem->units. ' at ' .$cartItem->updated_at->format('Y-m-d H:i:s')]
        );

      
    }
    //adding units by product
    public function addUnitsProduct(int $id,ActionLogService $logger){
        $cartItem = $this->cartItem->addUnitsProduct($id);
        $logger->log(
            auth()->user()->id,
            'add extra units',
            CartItem::class,
            $cartItem->id,
            ['action' => auth()->user()->name . ' increased  the units of ' . $cartItem->product_name . ' to  ' .$cartItem->units. ' at ' .$cartItem->updated_at->format('Y-m-d H:i:s')]
        );

      
    }
    
    //reducing units
    public function subtractUnits(int $id,ActionLogService $logger){
        
        $cartItem = $this->cartItem->subtractUnits($id);
        $logger->log(
            auth()->user()->id,
            'reduce units',
            CartItem::class,
            $cartItem->id,
            ['action' => auth()->user()->name . ' decreased  the units of ' . $cartItem->product_name . ' to  ' .$cartItem->units. ' at ' .$cartItem->updated_at->format('Y-m-d H:i:s')]
        );

    }
    //reducing units by product
    public function subtractUnitsProduct(int $id,ActionLogService $logger){
        
        $cartItem = $this->cartItem->subtractUnitsProduct($id);
        $logger->log(
            auth()->user()->id,
            'reduce units',
            CartItem::class,
            $cartItem->id,
            ['action' => auth()->user()->name . ' decreased  the units of ' . $cartItem->product_name . ' to  ' .$cartItem->units. ' at ' .$cartItem->updated_at->format('Y-m-d H:i:s')]
        );

    }
    //checkout function
     public function toCheckout(ActionLogService $logger){
        $cartItems = $this->cartItem->lockForUpdateGet();
        foreach ($cartItems as $item) {
            $product = $this->product->lockForUpdateProduct($item);
            $product->decrement('stock_quantity', $item->units);

            $logger->log(
                auth()->user()->id,
                'reduce units',
                CartItem::class,
                $item->id,
                ['action' => auth()->user()->name . ' has bought ' .$item->units. ' units of ' . $item->product_name .  ' at ' .$item->updated_at->format('Y-m-d H:i:s')]
            );
            if($product->stock_quantity <= 5){
                dispatch(new LowStockNotification());
            }
        }
        $cartItems = $this->cartItem->updateBuyTrue();
    }

}