<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Stringable;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    // protected static function booted()
    // {
    //     static::addGlobalScope('store', function (Builder $builder) {
    //         $user = Auth::user();
    //         $builder->where('store_id', '=', $user->store_id);
    //     });
    // }


    protected $hidden= [

        "deleted_at","created_at","updated_at"

    ];

    protected $appends =[
        'image_url'
    ];
    protected $fillable = [

        'name', 'description', 'status', 'image', 'slug', 'store_id', 'category_id', 'price', 'compare_price', 'options', 'rating', 'featured'

    ];

    public function getImageUrlAttribute(){
        if(!$this->image){

            return "https://www.incathlab.com/images/products/default_product.pen";

        }
        if(Str::startsWith($this->image, ['http//','https//'])){
            return $this->image;

        }
        return asset('storage/' .$this->image);
    }
}
