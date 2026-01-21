<?php
namespace App\Services;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Jobs\LowStockNotification;

class ProductService extends Controller
{
    private $cartItem;
    private $product;
    
    public function __construct(CartItem $cartItem,Product $product) {
        $this->cartItem = $cartItem;
        $this->product = $product;
    }

    public function getUnits(){
        
        $cartItem = $this->getCartItem();
        if($cartItem == null){
            return;
        }else{
            return $cartItem->units;
        }   
    }

    public function checkCartItem($productId){

        $cartItem = $this->getCartItem($productId);
        if($cartItem == null){
            return false;
        }else{
            return true;
        }
    }


    public  function getCartItem(int $productId){

        return $this->cartItem->getCartItemByProduct($productId);
        
    }

    public  function addToCart($unit,$product_name,$product_id,$user_id,$product_price ){
        return $this->cartItem->addToCart($unit,$product_name,$product_id,$user_id,$product_price);
        
    }

    public function addUnits(int $id){
        $cartItem = $this->cartItem->addUnits($id);
      
    }

}