<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image_path',
        'is_my_like',
        'is_sold',
        'like_count',
        'comment_count',
        'bran',
        'description',
        'category_id',
        'condition_id'
    ];
    /**
     * 商品名で部分一致検索
     */
    public function scopeSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }
}
