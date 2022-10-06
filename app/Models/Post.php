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

    public function secret(?string $password): string
    {
        // $redem = $this->id . '|' . $password;
        $redem = "{$this->id}|{$password}";

        return encrypt($redem);
    }

    public function hasValidSecret(string $secret): bool
    {
        $decryptText = decrypt($secret);
        $explodeText = explode('|', $decryptText, 2);

        if ($explodeText[0] != $this->id) {
            return false;
        }

        return $this->isValidPassword($explodeText[1] ?? '');
    }

    public function hasPassword(): bool
    {
        return !blank($this->password);
    }

    public function isValidPassword(string $value): bool
    {
        return Hash::check($value, $this->password);
    }

    public function isTheOwner(?User $user)
    {
        return $this->user_id === $user->id;
    }
}
