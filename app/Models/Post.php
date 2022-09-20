<?php

namespace App\Models;

use App\Models\Concerns\UploadedFiles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Post extends Model
{
    use HasFactory, UploadedFiles;

    protected $fillable = [
        'name',
        'title',
        'body',
        'image',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // static method
    public function fileColumn(): string
    {
        return 'image';
    }

    public function filePath(): string
    {
        return 'img';
    }

    public function getStorageName(): string
    {
        return 'public';
    }

    public $deleteImage = false;

    // Relasi

    // Accesor and Mutator
    public function password(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if (blank($value)) return null;

                return Hash::needsRehash($value) ? Hash::make($value) : $value;
            }
        );
    }
}
