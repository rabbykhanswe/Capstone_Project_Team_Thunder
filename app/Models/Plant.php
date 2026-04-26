<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_count',
        'category',
        'image',
        'is_seasonal',
        'season',
        'care_instructions',
        'sunlight_requirements',
        'water_requirements',
        'environment',
        'plant_type',
        'image_gallery'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_count' => 'integer',
        'is_seasonal' => 'boolean',
        'image_gallery' => 'array'
    ];



    public function getFormattedPriceAttribute()
    {
        return '৳' . number_format($this->price, 2);
    }


    public function isInStock()
    {
        return $this->stock_count > 0;
    }


    public function getStockStatusAttribute()
    {
        if ($this->stock_count > 10) {
            return 'In Stock';
        } elseif ($this->stock_count > 0) {
            return 'Low Stock (' . $this->stock_count . ' left)';
        } else {
            return 'Out of Stock';
        }
    }

    public function getImageGalleryAttribute()
    {
        $gallery = $this->attributes['image_gallery'] ? json_decode($this->attributes['image_gallery'], true) : [];
        
        if ($this->image && !in_array($this->image, $gallery)) {
            array_unshift($gallery, $this->image);
        }
        
        return $gallery;
    }

    public function getGalleryImagesAttribute()
    {
        $gallery = $this->image_gallery;
        
        if (empty($gallery) && $this->image) {
            return [$this->image];
        }
        
        return $gallery;
    }

    public function scopeByEnvironment($query, $environment)
    {
        return $query->where('environment', $environment);
    }

    public function scopeByPlantType($query, $type)
    {
        return $query->where('plant_type', $type);
    }

    public function scopeInPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'LIKE', '%' . $term . '%')
                    ->orWhere('description', 'LIKE', '%' . $term . '%')
                    ->orWhere('category', 'LIKE', '%' . $term . '%');
    }
}
