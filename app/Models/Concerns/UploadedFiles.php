<?php

namespace App\Models\Concerns;

use App\Exceptions\UploadFileException;
use App\Jobs\DeletedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\FileSystem;

trait UploadedFiles
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function bootUploadedFiles()
    {
        static::saving(function (Model $model) {

            // dd($model->deleteImage);
            if ($model->deleteImage) {
                if (!is_null($model->fileColumn())) {
                    $model->deletePreviousFile();
                }

                $model->setAttribute($model->fileColumn(), null);

                return;
            }

            if ($model->isDirty($model->fileColumn())) {

                $image = $model->getAttribute($model->fileColumn());

                if ($image instanceof UploadedFile) {
                    $model->saveFile($image);

                    if ($model->hasPreviousFile()) {
                        $model->deletePreviousFile();
                    }
                } else {
                    $model->setAttribute($model->fileColumn(), $model->getRawOriginal($model->fileColumn()));
                }
            }
        });

        static::deleting(function (Model $model) {
            $model->deletePreviousFile();
        });
    }

    public function saveFile(UploadedFile $image): void
    {
        $filename = $this->getUploadedFileName(file: $image);

        $uploaded = $image->storeAs(
            path: $this->filePath(),
            name: $filename,
            options: $this->getStorageName()
        );

        if (!$uploaded) {
            throw new UploadFileException($this->getFailedMessage(), 1);
        }

        $this->setAttribute($this->fileColumn(), $filename);

        if (!is_null($this->getOriginal($this->fileColumn()))) {
            $this->deletePreviousFile();
        }
    }

    public function fileColumn(): string
    {
        return 'image';
    }

    public function getUploadedFileName(UploadedFile $file): string
    {
        return $file->hashName();
    }

    public function filePath(): string
    {
        return 'img';
    }

    public function getStorageName(): string
    {
        return config('filesystems.default', 'public');
    }

    public function getFailedMessage(): string
    {
        return 'Failed to uploaded file';
    }

    public function hasFile(): bool
    {
        return !blank($this->getAttribute($this->fileColumn()));
    }

    public function getFileStorage(): FileSystem | FilesystemAdapter
    {
        return Storage::disk($this->getStorageName());
    }

    public function getFullFilePath(): string
    {
        return $this->filePath() . '/' . $this->getAttribute($this->fileColumn());
    }

    public function hasPreviousFile(): bool
    {
        return !blank($this->getRawOriginal($this->fileColumn()));
    }

    public function getPreviousFilePath(): string
    {
        return $this->filePath() . '/' . $this->getRawOriginal($this->fileColumn());
    }

    /**
     * delete file with job after DB:commit operation
     *
     * @return void
     */
    public function deletePreviousFile(): void
    {
        if (!$this->hasPreviousFile()) {
            return;
        }

        DeletedFile::dispatch(
            $this->getPreviousFilePath(),
            $this->getStorageName()
        )->afterCommit();
    }

    /**
     * get the image file asset_url
     *
     * @return string|null
     */
    public function getImageAsset(): ?string
    {
        if (!$this->hasFile()) {
            return null;
        }

        return $this->getFileStorage()->url($this->getFullFilePath());
    }
}
