<?php

namespace App\Http\Controllers\User;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CartRepository;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    protected $cartRepo;
    public function __construct(CartRepository $cartRepo) 
    {
        $this->cartRepo = $cartRepo; 
    }
    //
    public function view(Request $request, Product $product)
    {
        $user = $request->user();
        if($user) {
            $cartItem = CartItem::where('user_id', $user->id)->get();
            $userAddress = UserAddress::where('user_id', $user->id)->where('isMain', 1)->first();
            if($cartItem->count() > 0) {
                return Inertia::render('User/CartList',
                    [
                        'cartItems' => $cartItem,
                        'userAddress' => $userAddress
                    ]
                );
            }
        }else{
            $cartItems = Cart::getCookieCartItems();
            if (count($cartItems) > 0) {
                $cartItems = new CartResource(Cart::getProductsAndCartItems());
                return  Inertia::render('User/CartList', ['cartItems' => $cartItems]);
            } else {
                return redirect()->back();
            }
        }
    }

    public function store (Request $request, Product $product) 
    {
        $quantity = $request->post('quantity', 1);
        $user = $request->user();

        if($user) {
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            if($cartItem) {
                $cartItem->increment('quantity');

            }else{
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);

            }
        }else {
            $cartItem = Cart::getCookieCartItems();
            $isProductExists = false;
            foreach($cartItem as $item) {
                if ($item['product_id'] === $product->id) {
                    $item['quantity'] += $quantity;
                    $isProductExists = true;
                    break;
                }
            }
            if (!$isProductExists) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }
            Cart::setCookieCartItems($cartItems);
        }
        return redirect()->back()->with('success', 'cart added successfully');
    }

    public function update(Request $request, Product $product)
    {   
        $quatity = $request->integer('quantity');
        $user = $request->user();

        if($user) {
           CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->update(['quantity' => $quatity]);
        }else {
            $cartItems = Cart::getCookieCartItems();
            foreach ($cartItems as $items ) {
                if($items['product_id'] == $product->id) {
                    $items['quatity'] = $quatity;
                    break;
                }
            }
            Cart::setCookieCartItems($cartItems);
        }
        return redirect()->back();
    }
    public function delete(Request $request, Product $product)
    {
        $user = $request->user();
        if($user) {
            CartItem::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first()?->delete();
            if(CartItem::count() <= 0) {
                return redirect()->route('user.home')->with('info', 'your cart is empty');
            }else {
                return redirect()->back()->with('success', 'item removed successfully');
            }
        }else {
            $cartItems = Cart::getCookieCartItems();
            foreach($cartItems as $i => &$item) {
                if($item['product_id'] == $product->id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            Cart::setCookieCartItems($cartItems);
            if (count($cartItems) <= 0) {
                return redirect()->route('user.home')->with('info', 'your cart is empty');
            } else {
                return redirect()->back()->with('success', 'item removed successfully');
            }
        }
    }
}
