<?php

namespace App\Actions;

use Exception;
use App\Models\Product;
use App\Services\ImageService;

class SaveProduct
{
    private Product $product;
    private array $attributes;

    public function __construct(Product $product, array $attributes = [])
    {
        $this->product = $product;
        $this->attributes = $attributes;
    }

    public function handle(): void
    {
        if (isset($this->attributes['image'])) {

            $file = (new ImageService())->saveImage($this->attributes['image'], 'product');

            $this->attributes['image'] = $file['name'];
            
        }

        $this->product->fill($this->attributes)->save();
        
    }
}
