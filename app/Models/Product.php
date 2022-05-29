<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',     
        'description',
        'price',
        'image',
        'category_id'
    ];

    protected $appends = ['image_url', 'price_formatted'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {    
        return $this->image ? asset('upload/images/product/'.$this->image) : asset('images/default.png');
    }

    public function getPriceFormattedAttribute(): string
    {
        return price_format($this->price);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {

            $path = 'upload/images/product/'.$item->image;
            if(File::exists(public_path($path))){
                File::delete(public_path($path));
            }

        });
    }
}
