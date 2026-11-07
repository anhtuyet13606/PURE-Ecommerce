<?php
namespace App\Http\Controllers;
use App\Models\Product;use Illuminate\Http\Request;
class CartController extends Controller {
 public function index(){return view('store.cart',['cart'=>session('cart',[])]);}
 public function add(Request $r,Product $product){$data=$r->validate(['quantity'=>'nullable|integer|min:1|max:99']);$qty=$data['quantity']??1;if(!$product->is_active||$product->stock<$qty)return back()->withErrors(['cart'=>'Sản phẩm không đủ tồn kho.']);$cart=session('cart',[]);$id=$product->id;$new=($cart[$id]['quantity']??0)+$qty;if($new>$product->stock)return back()->withErrors(['cart'=>'Số lượng vượt quá tồn kho.']);$cart[$id]=['id'=>$id,'name'=>$product->name,'price'=>(float)$product->current_price,'image'=>$product->image,'quantity'=>$new];session(['cart'=>$cart]);return back()->with('success','Đã thêm sản phẩm vào giỏ hàng.');}
 public function update(Request $r,Product $product){$data=$r->validate(['quantity'=>'required|integer|min:1|max:99']);$cart=session('cart',[]);if(isset($cart[$product->id])){if($data['quantity']>$product->stock)return back()->withErrors(['cart'=>'Số lượng vượt tồn kho.']);$cart[$product->id]['quantity']=$data['quantity'];session(['cart'=>$cart]);}return back();}
 public function remove(Product $product){$cart=session('cart',[]);unset($cart[$product->id]);session(['cart'=>$cart]);return back()->with('success','Đã xóa sản phẩm.');}
}
