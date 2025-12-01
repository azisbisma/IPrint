<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'weight',
        'photo',
        'stock',
        'condition',
        'status',
        'price',
        'discount',
        'cat_id',
        'brand_id',
    ];

    public function cat_info(){
        return $this->hasOne('App\Models\Category','id','cat_id');
    }
    public static function getAllProduct(){
        return Product::with(['cat_info'])->orderBy('id','desc')->paginate(10);
    }
    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('aktif','nonaktif')->orderBy('id','DESC')->limit(8);
    }
    public function brand(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }
    public static function getProductBySlug($slug){
        return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    }
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount) {
            return $this->price - ($this->price * $this->discount / 100);
        }
        return $this->price;
    }

    public function carts(){
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    public function orders(){
        return $this->belongsToMany(Order::class,'product_orders')->withPivot('quantity');
    }

}
