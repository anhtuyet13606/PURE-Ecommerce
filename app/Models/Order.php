<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
 protected $fillable=['user_id','order_code','customer_name','email','phone','address','subtotal','shipping_fee','discount','total','payment_method','payment_status','status','notes'];
 protected $casts=['subtotal'=>'decimal:2','shipping_fee'=>'decimal:2','discount'=>'decimal:2','total'=>'decimal:2'];
 public function items(){return $this->hasMany(OrderItem::class);}
 public function user(){return $this->belongsTo(User::class);}
}
