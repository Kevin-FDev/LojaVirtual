<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos via formulário
    protected $fillable = ['name'];

    /**
     * Relacionamento: Um Tipo possui muitos Produtos
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}