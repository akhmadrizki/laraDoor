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
        'user_id',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function secret(): Attribute
    {
        return Attribute::make(
            get: fn () => encrypt($this->id)
        );
    }

    public function hasValidSecret(string $secret): bool
    {
        return $this->id == decrypt($secret);
    }

    public function hasPassword(): bool
    {
        return !blank($this->password);
    }

    public function isValidPassword($value, $hashedValue): bool
    {
        return Hash::check($value, $hashedValue);
    }

    public function isTheOwner($user)
    {
        return $this->user_id === $user->id;
    }
}
