<?php
namespace App\Http\Controllers;
use App\Models\{Product,Category,Order,User,Coupon};use Illuminate\Http\Request;use Illuminate\Support\Str;
class AdminController extends Controller {
 public function dashboard(){ $revenue=Order::where('payment_status','paid')->sum('total');$orders=Order::count();$products=Product::count();$customers=User::where('role','customer')->count();$latest=Order::latest()->take(8)->get();return view('admin.dashboard',compact('revenue','orders','products','customers','latest')); }
 public function products(){ $products=Product::with('category')->latest()->paginate(15);$categories=Category::all();return view('admin.products',compact('products','categories')); }
 public function saveProduct(Request $r){$data=$r->validate(['name'=>'required|max:180','category_id'=>'nullable|exists:categories,id','sku'=>'required|max:80|unique:products,sku'.($r->id?','.$r->id:''),'price'=>'required|numeric|min:0','sale_price'=>'nullable|numeric|min:0|lt:price','stock'=>'required|integer|min:0','description'=>'nullable|string','image'=>'nullable|url','is_active'=>'nullable|boolean','featured'=>'nullable|boolean']);$data['slug']=Str::slug($data['name']).'-'.Str::lower(Str::random(5));$data['is_active']=$r->boolean('is_active');$data['featured']=$r->boolean('featured');if($r->id){$p=Product::findOrFail($r->id);unset($data['slug']);$p->update($data);}else Product::create($data);return back()->with('success','Đã lưu sản phẩm.');}
 public function deleteProduct(Product $product){$product->delete();return back()->with('success','Đã xóa sản phẩm.');}
 public function categories(){ $categories=Category::withCount('products')->latest()->get();return view('admin.categories',compact('categories')); }
 public function saveCategory(Request $r){$data=$r->validate(['name'=>'required|max:120','description'=>'nullable|string']);Category::create(['name'=>$data['name'],'slug'=>Str::slug($data['name']).'-'.Str::lower(Str::random(4)),'description'=>$data['description']??null]);return back()->with('success','Đã thêm danh mục.');}
 public function deleteCategory(Category $category){$category->delete();return back()->with('success','Đã xóa danh mục.');}
 public function orders(){ $orders=Order::with('items')->latest()->paginate(20);return view('admin.orders',compact('orders')); }
 public function updateOrder(Request $r,Order $order){$data=$r->validate(['status'=>'required|in:pending,processing,shipped,delivered,cancelled','payment_status'=>'required|in:pending,paid,failed']);$order->update($data);return back()->with('success','Đã cập nhật đơn hàng.');}
 public function customers(){ $customers=User::where('role','customer')->latest()->paginate(20);return view('admin.customers',compact('customers')); }
 public function coupons(){ $coupons=Coupon::latest()->paginate(20);return view('admin.coupons',compact('coupons'));}
 public function saveCoupon(Request $r){$d=$r->validate(['code'=>'required|string|max:40|unique:coupons,code','type'=>'required|in:fixed,percent','value'=>'required|numeric|min:0.01','min_order'=>'nullable|numeric|min:0','max_discount'=>'nullable|numeric|min:0','usage_limit'=>'nullable|integer|min:1','expires_at'=>'nullable|date']);Coupon::create($d+['code'=>strtoupper($d['code']),'is_active'=>true]);return back()->with('success','Đã tạo mã giảm giá.');}
 public function deleteCoupon(Coupon $coupon){$coupon->delete();return back()->with('success','Đã xóa mã giảm giá.');}
 public function reports(){ $revenue=Order::where('payment_status','paid')->sum('total');$daily=Order::where('payment_status','paid')->where('created_at','>=',now()->subDays(6)->startOfDay())->selectRaw('DATE(created_at) day, SUM(total) total')->groupBy('day')->orderBy('day')->get();return view('admin.reports',compact('revenue','daily'));}
}
