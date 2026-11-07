<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
 protected $fillable=['category_id','name','slug','sku','description','price','sale_price','stock','image','is_active','featured'];
 protected $casts=['price'=>'decimal:2','sale_price'=>'decimal:2','is_active'=>'boolean','featured'=>'boolean'];
 public function category(){return $this->belongsTo(Category::class);} public function reviews(){return $this->hasMany(Review::class);} public function wishlistedBy(){return $this->belongsToMany(User::class,'wishlists');}
 public function getCurrentPriceAttribute(){return $this->sale_price && $this->sale_price < $this->price ? $this->sale_price : $this->price;}
}
