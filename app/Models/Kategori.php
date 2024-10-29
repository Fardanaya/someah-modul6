<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Scopes\ActiveKategoriScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kategori extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    // protected $table = 'kategori';
    public $incrementing = false;
    protected $keyType = 'uuid';

    // protected static function booted()
    // {
    //     static::addGlobalScope(new ActiveKategoriScope);
    // }

    protected $fillable = [
        'id',
        'nama_kategori', 
        'deskripsi'
    ];

    public function produk() {
        return $this->hasMany(Produk::class);
    }
}
