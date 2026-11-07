<?php
namespace Database\Seeders;
use App\Models\{User,Category,Product,Coupon};use Illuminate\Database\Seeder;use Illuminate\Support\Facades\Hash;use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder {public function run():void {
 User::updateOrCreate(['email'=>'admin@pure.vn'],['name'=>'PURE Administrator','password'=>Hash::make('Pure@12345'),'role'=>'admin','phone'=>'0900000000']);
 $cats=['Thời trang','Điện tử','Gia dụng','Chăm sóc cá nhân'];foreach($cats as $name){$c=Category::firstOrCreate(['slug'=>Str::slug($name)],['name'=>$name,'is_active'=>true]);}
 $samples=[['Áo thun PURE Essential','Thời trang',249000,199000,35,'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=900'],['Tai nghe không dây AirBeat','Điện tử',890000,759000,20,'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=900'],['Bình giữ nhiệt Minimal','Gia dụng',320000,null,40,'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=900'],['Sữa rửa mặt dịu nhẹ','Chăm sóc cá nhân',185000,null,50,'https://images.unsplash.com/photo-1556229010-6c3f2c9ca5f8?w=900'],['Áo sơ mi Classic','Thời trang',399000,349000,18,'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=900'],['Đèn bàn LED','Gia dụng',450000,null,15,'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=900']];
 Coupon::updateOrCreate(['code'=>'PURE10'],['description'=>'Giảm 10% tối đa 100.000đ','type'=>'percent','value'=>10,'min_order'=>300000,'max_discount'=>100000,'usage_limit'=>500,'is_active'=>true]);
 foreach($samples as $i=>$s){$cat=Category::where('name',$s[1])->first();Product::updateOrCreate(['sku'=>'PURE-'.str_pad((string)($i+1),4,'0',STR_PAD_LEFT)],['category_id'=>$cat->id,'name'=>$s[0],'slug'=>Str::slug($s[0]).'-'.($i+1),'description'=>'Sản phẩm chất lượng được PURE tuyển chọn. Thiết kế hiện đại, dễ sử dụng và phù hợp nhu cầu hằng ngày.','price'=>$s[2],'sale_price'=>$s[3],'stock'=>$s[4],'image'=>$s[5],'is_active'=>true,'featured'=>$i<4]);}
 }}
