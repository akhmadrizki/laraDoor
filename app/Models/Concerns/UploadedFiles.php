<?php

namespace App\Models\Concerns;

use App\Exceptions\UploadFileException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadedFiles
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // parent::booted();
        static::saving(function (Model $model) {

            // dd($model->deleteImage);
            if ($model->deleteImage) {
                if (!is_null($model->image)) {
                    Storage::disk($model->fileUpload['disk'])->delete($model->fileUpload['path'] . '/' . $model->image);
                }

                $model->image = null;

                return;
            }

            if ($model->isDirty($model->fileUpload['name'])) {
                // $image = $model->image;
                $image = $model->getAttribute($model->fileUpload['name']);
                // dd($image);

                if ($image instanceof UploadedFile) {
                    $filename = $image->hashName();

                    $uploaded = $image->storeAs(
                        path: $model->fileUpload['path'],
                        name: $filename,
                        options: $model->fileUpload['disk']
                    );

                    if (!$uploaded) {
                        throw new UploadFileException("Uploaded image fail", 1);
                    }

                    $model->setAttribute($model->fileUpload['name'], $filename);

                    if (!is_null($model->getOriginal($model->fileUpload['name']))) {
                        Storage::disk($model->fileUpload['disk'])->delete($model->fileUpload['path'] . '/' . $model->getOriginal($model->fileUpload['name']));
                    }
                } else {
                    $model->setAttribute($model->fileUpload['name'], $model->getOriginal($model->fileUpload['name']));
                }
            }
        });

        static::deleting(function (Model $model) {
            if (!is_null($model->getAttribute($model->fileUpload['name']))) {
                Storage::disk($model->fileUpload['disk'])->delete($model->fileUpload['path'] . '/' . $model->getAttribute($model->fileUpload['name']));
            }
        });
    }

    public function getImageAsset(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        return Storage::disk($this->fileUpload['disk'])->url($this->fileUpload['path'] . '/' . $this->image);
    }


    // protected string $fieldName;
    // protected string $fieldPath;
    // protected string $fieldOption;

    // /**
    //  * The "booted" method of the model.
    //  *
    //  * @return void
    //  */
    // public static function savingImage($fieldName = 'image', $fieldPath = 'img', $fieldOption = 'public'): static
    // {
    //     $query = new static;

    //     $query->fieldName = $fieldName;
    //     $query->fieldPath = $fieldPath;
    //     $query->fieldOption = $fieldOption;

    //     // taro di trait (nanti disini cuma buat ganti dinamis path, options, name)
    //     static::saving(function (Model $model) use ($query) {
    //         if ($model->isDirty($query->fieldName)) {
    //             $image = $model->image;

    //             if ($image instanceof UploadedFile) {
    //                 $filename = $image->hashName();

    //                 $uploaded = $image->storeAs(
    //                     path: 'img',
    //                     name: $filename,
    //                     options: 'public'
    //                 );

    //                 if (!$uploaded) {
    //                     // di custom (UploadFileException)
    //                     throw new UploadFileException("Error Processing Request", 1);
    //                 }

    //                 $model->image = $filename;
    //             }
    //         }
    //     });
    //     return $query;
    // }

    // public function getImageAsset(): string
    // {
    //     if (blank($this->image)) {
    //         return null;
    //     }

    //     return Storage::disk('public')->url('img/' . $this->image);
    // }
}
