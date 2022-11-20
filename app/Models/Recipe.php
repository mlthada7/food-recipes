<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    // protected $guarded = ['id'];
    protected $fillable = [
        'title',
        'description',
        'ingredients',
        'methods',
        'image',
        'user_id'
    ];

    /**
     * Get the user that owns the Recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}