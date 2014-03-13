<?php

namespace Zoop\Common\Upload\Storage\S3;

use Upload\File;
use Upload\Storage\Base;
use Zoop\Common\Aws\S3\S3 as S3Client;

/**
 * AWS S3 Storage
 *
 * This class uploads files to a designated directory to S3
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 * @since   1.0.0
 * @package Upload
 */
class S3 extends Base
{
    /**
     * AWS S3 Client
     * @var S3Client
     */
    protected $s3;

    /**
     * Upload directory
     * @var string
     */
    protected $directory;

    /**
     * Constructor
     * @param  string                       $directory      Relative or absolute path to upload directory
     * @param  bool                         $overwrite      Should this overwrite existing files?
     * @throws \InvalidArgumentException                    If directory does not exist
     * @throws \InvalidArgumentException                    If directory is not writable
     */
    public function __construct(S3Client $s3, $directory)
    {
        $this->setS3($s3);
        $this->setDirectory(trim($directory, '/') . DIRECTORY_SEPARATOR);
    }

    /**
     * Upload
     * @param File $file The file object to upload
     * @param  string $newName Give the file it a new name
     * @return bool
     * @throws \RuntimeException   If overwrite is false and file already exists
     */
    public function upload(File $file, $newName = null)
    {
        if (is_string($newName)) {
            $fileName = strpos($newName, '.') ? $newName : $newName . '.' . $file->getExtension();
        } else {
            $fileName = $file->getNameWithExtension();
        }

        $filepath = $this->getDirectory() . $fileName;

        $data = file_get_contents($file->getPathname());

        return $this->uploadedFile($filepath, $data);
    }

    protected function uploadedFile($filepath, $data)
    {
        return $this->getS3()->put($filepath, $data);
    }

    /**
     *
     * @return S3Client
     */
    public function getS3()
    {
        return $this->s3;
    }

    /**
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     *
     * @param S3Client $s3
     */
    public function setS3(S3Client $s3)
    {
        $this->s3 = $s3;
    }

    /**
     *
     * @param string $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }
}
