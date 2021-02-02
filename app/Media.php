<?php

namespace App;

use App\Traits\RelativeTime;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/**
 * Class Media
 * @package App
 */
class Media extends Model
{
    use RelativeTime;

    protected $fillable = ['name', 'type', 'size', 'path', 'url', 'storage', 'user_id'];
    protected $appends = ['created_ago', 'updated_ago'];

    // Static Global Variables
    protected static array $allowedExtensions = ['jpeg', 'jpg', 'png', 'bmp', 'gif', 'svg'];
    protected static int $maxSize = 10; //megabytes
    protected static string $visibility = 'public';
    protected static string $subDirectoryPath = 'media';

    public function author(): BelongsTo
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany('App\Category', 'media_id');
    }

    public function pages(): HasMany
    {
        return $this->hasMany('App\Page', 'media_id');
    }

    /**
     * Stores the given file with given name.
     * If the parameter "register" is set to true (by default), the media
     * file information will also be written in the media table in database.
     * If this flag is set to false, the file will be stored in the disk only.
     *
     * @param $file
     * @param string $name
     * @param string $subDirectory
     * @param bool $register
     * @return Media
     * @throws Exception
     */
    public static function store($file, $name = null, $subDirectory = null, $register = true): Media
    {
        $diskStorageType = self::configureAndGetDiskStorageType();

        try {
            $sizeInBytes = $file->getSize(); // bytes

            self::_checkFileError($file, $sizeInBytes);

            if ($subDirectory === null) {
                $subDirectory = self::$subDirectoryPath;
            }

            if (config('filesystems.media') == 'spaces') {
                $subDirectory = config('filesystems.media_domain') . '/' . $subDirectory;
            }

            $path = Storage::disk($diskStorageType)->putFile(
                $subDirectory,
                $file,
                self::$visibility
            );

            $media = new Media([
                'name' => empty($name) ? $file->getClientOriginalName() : $name,
                'type' => $file->guessExtension(),
                'size' => round($sizeInBytes / 1024, 2), // kilobytes
                'path' => $path,
                'url' =>
                    $diskStorageType === 'public'
                        ? '/storage/' . $path
                        : str_replace(
                        'digitaloceanspaces',
                        'cdn.digitaloceanspaces',
                        Storage::disk($diskStorageType)->url($path)
                    ),
                'storage' => $diskStorageType,
                'user_id' => Auth::id(),
            ]);

            if ($register) {
                $media->save();
            }

            return $media;

        } catch (Exception $e) {
            if (!empty($path)) {
                if (Storage::disk($diskStorageType)->exists($path)) {
                    Storage::disk($diskStorageType)->delete($path);
                }
                if (!empty($media) && $register === true) {
                    $media->delete();
                }
            }

            throw $e;
        }
    }

    /**
     * Stores the given base64 encoded data as image file. The file name
     * must be provided without the extension as extension will be determined
     * from the mime type of the provided data.
     *
     * If the parameter "register" is set to true (by default), the media
     * file information will also be written in the media table in database.
     * If this flag is set to false, the file will be stored in the disk only.
     *
     * @param $encoded
     * @param string $name
     * @param string $subDirectory
     * @param bool $register
     * @return Media
     * @throws Exception
     */
    public static function storeFromBase64($encoded, string $name, $subDirectory = null, $register = true): Media
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $encoded, $fileType)) {
            $encoded = substr($encoded, strpos($encoded, ',') + 1);
            $fileType = strtolower($fileType[1]); // jpg, png, gif

            $decodedImage = base64_decode($encoded);

            if ($decodedImage === false) {
                throw new Exception('base64_decode failed');
            }
        } else {
            throw new Exception('did not match data URI with image data');
        }

        $diskStorageType = self::configureAndGetDiskStorageType();

        try {
            if ($subDirectory === null) {
                $subDirectory = self::$subDirectoryPath;
            }

            if (config('filesystems.media') == 'spaces') {
                $subDirectory = config('filesystems.media_domain') . '/' . $subDirectory;
            }

            $path = $subDirectory . '/' . $name . '.' . $fileType;

            Storage::disk($diskStorageType)->put($path, $decodedImage, self::$visibility);

            $media = new Media([
                'name' => $name . '.' . $fileType,
                'type' => $fileType,
                'size' => round(strlen($decodedImage) / 1024, 2), // kilobytes
                'path' => $path,
                'url' =>
                    $diskStorageType === 'public'
                        ? '/storage/' . $path
                        : str_replace(
                        'digitaloceanspaces',
                        'cdn.digitaloceanspaces',
                        Storage::disk($diskStorageType)->url($path)
                    ),
                'storage' => $diskStorageType,
                'user_id' => Auth::id(),
            ]);

            if ($register) {
                $media->save();
            }

            return $media;

        } catch (Exception $e) {
            if (!empty($path)) {
                if (Storage::disk($diskStorageType)->exists($path)) {
                    Storage::disk($diskStorageType)->delete($path);
                }
                if (!empty($media) && $register === true) {
                    $media->delete();
                }
            }

            throw $e;
        }
    }

    /**
     * Delete the media and removes the file from storage.
     *
     * @return bool|null
     * @throws Exception
     */
    public function delete(): ?bool
    {
        Storage::disk($this->storage)->delete($this->path);

        return parent::delete();
    }

    private static function configureAndGetDiskStorageType(): string
    {
        if (config('filesystems.media') == 'spaces') {
            return 'spaces';
        }

        return 'public';
    }

    private static function setS3StorageParameters($key, $secret, $region, $bucket)
    {
        Config::set('filesystems.disks.s3.key', $key);
        Config::set('filesystems.disks.s3.secret', $secret);
        Config::set('filesystems.disks.s3.region', $region);
        Config::set('filesystems.disks.s3.bucket', $bucket);
    }

    private static function _checkFileError($file, $sizeInBytes)
    {
        if (!isset($file)) {
            abort(400, 'File not uploaded');
        }

        if (!in_array($file->guessExtension(), self::$allowedExtensions)) {
            abort(400, 'File type not allowed.');
        }

        if ($sizeInBytes > self::$maxSize * 1024 * 1024 || $sizeInBytes <= 0) {
            abort(400, 'File size error');
        }
    }
}
