<?php

namespace App;

use App\Traits\RelativeTime;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Throwable;

/**
 * Asset model stores all the media as well as other type of files uploaded by the user.
 *
 * @package App
 */
class Asset extends Model
{
    protected static array $allowedDocumentExtensions = ['key', 'pps', 'ppt', 'pptx', 'odp', 'xls', 'xlsm', 'xlsx', 'doc', 'docx', 'pdf', 'rtf', 'tex', 'txt'];

    use RelativeTime;

    // Static Global Variables
    protected static array $allowedImageExtensions = ['jpeg', 'jpg', 'png', 'bmp', 'gif', 'svg', 'raw', 'ai', 'ico', 'psd', 'tif', 'tiff'];
    protected static array $allowedAudioExtensions = ['cda', 'mp3', 'ogg', 'wav', 'wma'];
    protected static array $allowedVideoExtensions = ['h264', 'avi', 'mp4', 'mov', 'm4v', 'mkv', 'mpg', 'mpeg', 'rm', 'vob', 'wmv'];
    protected static array $allowedProgramExtensions = ['c', 'cpp', 'class', 'cs', 'h', 'java', 'php', 'py', 'sh', 'swift', 'vb'];
    protected static array $allowedInternetExtensions = ['css', 'htm', 'html', 'js', 'rss', 'xhtml'];
    protected static array $allowedCompressedExtensions = ['.7z', 'zip', 'rar', 'tar.gz'];
    protected static int $maxSizeInMB = 25;
    protected static string $visibility = 'public';
    protected static string $defaultMediaDirectory = 'media';
    protected $table = 'media';

    // model variables
    protected $fillable = ['name', 'type', 'size', 'path', 'url', 'storage', 'user_id'];
    protected $appends = ['created_ago', 'updated_ago'];

    /**
     * Stores the given base64 encoded data as image file. The file name
     * must be provided without the extension as extension will be determined
     * from the mime type of the provided data.
     *
     * If the parameter "register" is set to true (by default), the media
     * file information will also be written in the media table in database.
     * If this flag is set to false, the file will be stored in the disk only.
     *
     * @param string $encoded
     * @param string $name
     * @param string|null $givenDirectory
     * @param bool $register
     * @return Asset
     * @throws Exception
     */
    public static function storeFromBase64(string $encoded, string $name, $givenDirectory = null, $register = true): Asset
    {
        if (empty($encoded) || empty($name)) {
            throw new InvalidArgumentException("Image name and encoded image data must be present.");
        }

        $fileType = self::checkFileTypeInEncodedUri($encoded);
        $decodedImage = self::getImageDataFromEncodedUri($encoded);

        $mediaDisk = self::getMediaDisk();
        $mediaDirectory = self::getMediaDirectory($givenDirectory);

        $fileName = $name . '.' . $fileType;
        $path = $mediaDirectory . '/' . $fileName;

        try {
            Storage::disk($mediaDisk)->put($path, $decodedImage, self::$visibility);

            $media = new Asset([
                'name' => $fileName,
                'type' => self::getFileType($fileType),
                'size' => round(strlen($decodedImage) / 1024, 2), // kilobytes
                'path' => $path,
                'url' => self::pathToPublicUrl($path),
                'storage' => $mediaDisk,
                'user_id' => Auth::id(),
            ]);

            if ($register) $media->save();

            return $media;

        } catch (Exception $e) {

            self::removeFileIfPresent($mediaDisk, $path);

            if (!empty($media) && $register === true) {
                $media->delete();
            }

            throw $e;
        }
    }

    /**
     * @param string $encodedUri
     * @return string
     * @throws Exception
     */
    private static function checkFileTypeInEncodedUri(string $encodedUri): string
    {
        $matches = [];
        $patternFound = preg_match('/^data:image\/(\w+);base64,/', $encodedUri, $matches);

        if (!$patternFound) {
            throw new Exception('Encoded URI data is invalid.');
        }

        $fileType = strtolower($matches[1]);
        if (!in_array($fileType, self::$allowedImageExtensions)) {
            throw new Exception('Encoded URI data contains invalid image type');
        }

        return $fileType;
    }

    /**
     * @param string $encodedUri
     * @return string
     * @throws Exception
     */
    private static function getImageDataFromEncodedUri(string $encodedUri): string
    {
        $encodedData = substr($encodedUri, strpos($encodedUri, ',') + 1);
        $decodedImage = base64_decode($encodedData);

        if ($decodedImage === false) {
            throw new Exception('Unable to decode the image data from the Base64 encoded URI.');
        }

        return $decodedImage;
    }

    /**
     * Returns the name of the disk, from the list of disks
     * defined under config/filesystems, that is to be
     * used for storing media files.
     *
     * @return string
     */
    private static function getMediaDisk(): string
    {
        return config('filesystems.media') === 'spaces' ? 'spaces' : 'public';
    }

    /**
     * Determines the directories for storing this media. If the given
     * directory is empty, it returns the default path.
     *
     * If "spaces" is used as the disk, then it adds the domain name
     * as prefix, so that the images are stored under the domain
     * name subdirectory.
     *
     * @param string|null $directory
     * @return string
     */
    private static function getMediaDirectory(string $directory = null): string
    {
        if ($directory === null) {
            $directory = self::$defaultMediaDirectory;
        }

        $prefix = config('filesystems.media') == 'spaces'
            ? config('filesystems.media_domain') . '/'
            : '';

        return $prefix . $directory;
    }

    private static function getFileType($extension): string
    {
        if (in_array($extension, self::$allowedDocumentExtensions)) return 'document';
        if (in_array($extension, self::$allowedImageExtensions)) return 'image';
        if (in_array($extension, self::$allowedAudioExtensions)) return 'audio';
        if (in_array($extension, self::$allowedVideoExtensions)) return 'video';
        if (in_array($extension, self::$allowedProgramExtensions)) return 'program';
        if (in_array($extension, self::$allowedInternetExtensions)) return 'internet';
        if (in_array($extension, self::$allowedCompressedExtensions)) return 'compressed';
    }

    /**
     * Given the media path, it returns the public url of the media.
     *
     * @param string $path
     * @return string
     */
    private static function pathToPublicUrl(string $path): string
    {
        switch (self::getMediaDisk()) {
            case "spaces":
                $url = Storage::disk("spaces")->url($path);
                return self::isCdnEnabled()
                    ? str_replace('digitaloceanspaces', 'cdn.digitaloceanspaces', $url)
                    : $url;

            default:
                return '/storage/' . $path;
        }
    }

    /**
     * Checks the configuration parameters and determines is cdn is enabled.
     *
     * @return bool
     */
    private static function isCdnEnabled(): bool
    {
        return true;
    }

    private static function removeFileIfPresent($disk, $path)
    {
        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
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
        $this->removeFileIfPresent($this->storage, $this->path);

        return parent::delete();
    }

    /**
     * @param string $url
     * @return Asset
     * @throws Throwable
     */
    public static function download(string $url): Asset
    {
        // create a temp file
        $tempFile = tmpfile();
        $tempFilePath = (string)stream_get_meta_data($tempFile)['uri'];

        $urlContents = file_get_contents($url);

        throw_if(
            $urlContents === false,
            InvalidArgumentException::class,
            ["Failed to read the data from the URL."]
        );

        // transfer the downloaded contents to temp file
        // then create UploadedFile from the temp file.
        file_put_contents($tempFilePath, $urlContents);
        $fileName = 'download_at_' . Carbon::now()->format('Y-m-d_H:i:s') . '_' . random_int(0, 9);
        $uploadedFile = new UploadedFile($tempFilePath, $fileName);

        return Asset::store($uploadedFile);
    }

    /**
     * Stores the given media file with the given name.
     *
     * If the parameter "register" is set to true (by default), the media
     * file information will also be written in the media table in database.
     * If this flag is set to false, the file will be stored in the disk only.
     *
     * @param UploadedFile $file
     * @param null|string $name
     * @param null|string $givenDirectory
     * @param bool $register
     * @return Asset
     * @throws Exception
     */
    public static function store(UploadedFile $file, $name = null, $givenDirectory = null, $register = true): Asset
    {
        self::validateUploadedFile($file);

        $mediaDisk = self::getMediaDisk();
        $mediaDirectory = self::getMediaDirectory($givenDirectory);
        $path = '';

        try {
            $path = Storage::disk($mediaDisk)->putFile($mediaDirectory, $file, self::$visibility);

            $media = new Asset([
                'name' => $name ?? $file->getClientOriginalName(),
                'type' => self::getFileType($file->guessExtension()),
                'size' => round($file->getSize() / 1024, 2),
                'path' => $path,
                'url' => self::pathToPublicUrl($path),
                'storage' => $mediaDisk,
                'user_id' => Auth::id(),
            ]);

            if ($register) $media->save();

            return $media;

        } catch (Exception $e) {

            self::removeFileIfPresent($mediaDisk, $path);

            if (!empty($media) && $register === true) {
                $media->delete();
            }

            throw $e;
        }
    }

    /**
     * Validate the file against extension and size limits.
     *
     * @param UploadedFile $file
     */
    private static function validateUploadedFile(UploadedFile $file)
    {
        if (!isset($file)) {
            abort(400, 'File not uploaded');
        }

        if (!in_array($file->guessExtension(), array_merge(
            self::$allowedDocumentExtensions,
            self::$allowedImageExtensions,
            self::$allowedAudioExtensions,
            self::$allowedVideoExtensions,
            self::$allowedProgramExtensions,
            self::$allowedInternetExtensions,
            self::$allowedCompressedExtensions
        ))) {
            abort(400, 'File type not allowed.');
        }

        if (strlen($file->getClientOriginalName()) === 0) {
            abort(400, 'Uploaded file does not have a name.');
        }

        $sizeInBytes = $file->getSize(); // bytes
        if ($sizeInBytes > self::$maxSizeInMB * 1024 * 1024 || $sizeInBytes <= 0) {
            abort(400, 'File size is more than the allowed limit of 25MB.');
        }
    }

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
}
