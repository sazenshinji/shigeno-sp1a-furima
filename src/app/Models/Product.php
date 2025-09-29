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
        'brand',
        'description',
        'seller_id',
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

    // 商品は1件の取引を持つ（購入済み判定用）
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    // 購入済みかどうか判定するアクセサ
    public function getIsSoldAttribute()
    {
        return $this->transaction()->exists();
    }

    // いいねされた関係
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
