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

    //cartItem,product
    public function __construct(CartItem $cartItem,Product $product) {
        $this->cartItem = $cartItem;
        $this->product = $product;
    }

    //units
    public function getUnits(){
        
        $cartItem = $this->getCartItem();
        if($cartItem == null){
            return;
        }else{
            return $cartItem->units;
        }   
    }
    
    //check if cartItem exists
    public function checkCartItem($productId){

        $cartItem = $this->getCartItem($productId);
        if($cartItem == null){
            return false;
        }else{
            return true;
        }
    }

    //cartItem 
    public  function getCartItem(int $productId){

        return $this->cartItem->getCartItemByProduct($productId);
        
    }
    //add to cart 
    public  function addToCart($unit,$product_name,$product_id,$user_id,$product_price ){
        return $this->cartItem->addToCart($unit,$product_name,$product_id,$user_id,$product_price);
        
    }

    //add units
    public function addUnits(int $id){
        $cartItem = $this->cartItem->addUnits($id);
      
    }

}