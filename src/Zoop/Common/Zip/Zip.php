<?php

namespace Zoop\Common\Zip;

use \ZipArchive;

class Zip
{
    private $directory;

    public function __construct($directory)
    {
        $this->setDirectory(trim($directory, '/') . DIRECTORY_SEPARATOR);
    }

    public function create($filename, $files = [], $removeFiles = false)
    {
        if (!empty($files)) {
            $filepath = $this->getDirectory() . $filename . '.zip';

            $zip = new ZipArchive();
            $zip->open($filepath, ZipArchive::CREATE);

            foreach ($files as $f) {
                if (is_file($f['file'])) {
                    $zip->addFile($f['file'], $f['fileName']);
                }
            }
            $zip->close();

            if ($removeFiles === true) {
                foreach ($files as $f) {
                    if (is_file($f['file'])) {
                        unlink($f['file']);
                    }
                }
            }

            return $filepath;
        }
        return false;
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
     * @param string $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }
}
