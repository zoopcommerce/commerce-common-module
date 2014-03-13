<?php

namespace Zoop\Common\Pdf;

use \DOMPDF;
use Zoop\Common\Zip\Zip;

class Pdf
{
    private $directory;
    private $zip;

    public function __construct(Zip $zip, $directory)
    {
        $this->setZip($zip);
        $this->setDirectory(trim($directory, '/') . DIRECTORY_SEPARATOR);
    }

    /**
     *
     * @param string $filename
     * @param array $files
     * @param boolean $compress
     * @return string|boolean
     */
    public function combine($filename, $files = [], $compress = false)
    {
        if (!empty($files)) {
            $filepath = $this->getDirectory() . $filename . '.pdf';
            $cmd = "gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=" . $filepath;
            exec($cmd . ' ' . implode(' ', $files));

            if ($compress === true) {
                return $this->getZip()->create($filename, [
                    'file' => $filepath,
                    'fileName' => $filename
                ], true);
            } else {
                return $filepath;
            }
        }
        return false;
    }

    /**
     *
     * @param string $filename
     * @param string $html
     * @return string
     */
    public function create($filename, $html)
    {
        $dompdf = new DOMPDF();

        $dompdf->set_paper('A4');
        $dompdf->load_html($html);
        $dompdf->render();

        $pdf = $dompdf->output();

        $filepath = $this->getDirectory() . $filename . '.pdf';

        // write pdf to file system
        file_put_contents($filepath, $pdf);

        return $filepath;
    }

    /**
     *
     * @return Zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     *
     * @param Zip $zip
     */
    public function setZip(Zip $zip)
    {
        $this->zip = $zip;
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
