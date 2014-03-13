<?php

namespace Zoop\Common\Aws\S3;

use \Exception;
use Aws\Common\Aws;
use Aws\S3\Enum\CannedAcl;
use Aws\S3\S3Client;

/**
 *
 *
 * @author Josh
 */
class S3
{
    private $s3Client;
    private $key;
    private $secret;
    private $bucket;
    public static $PUBLIC_ACL = 'public';
    public static $PRIVATE_ACL = 'private';

    public function __construct($key, $secret, $bucket)
    {
        $this->setKey($key);
        $this->setSecret($secret);
        $this->setBucket($bucket);
    }

    /**
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     *
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     *
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     *
     * @param string $bucket
     */
    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
    }

    /**
     *
     * @return S3Client
     */
    public function getS3Client()
    {
        if (!isset($this->s3Client)) {
            $aws = Aws::factory([
                'key' => $this->getKey(),
                'secret' => $this->getSecret()
            ]);

            $this->setS3Client($aws->get('s3'));
        }
        return $this->s3Client;
    }

    /**
     *
     * @param S3Client $s3Client
     */
    public function setS3Client(S3Client $s3Client)
    {
        $this->s3Client = $s3Client;
    }

    public function get($dir, $fileName, $saveLocal = false, $localDir = null, $localFileName = null)
    {
        try {
            $query = [
                'Bucket' => $this->getBucket(),
                'Key' => $dir . '/' . $fileName
            ];
            if ($saveLocal === true) {
                $query['SaveAs'] = $localDir . '/' . $localFileName;
            }

            $r = $this->getS3Client()->getObject($query);
        } catch (Exception $e) {
            return false;
        }

        if ($saveLocal === true) {
            return $localDir . '/' . $localFileName;
        } else {
            return (string) $r->get('Body');
        }
    }

    public function put($key, $data, $acl = null, $contentType = null)
    {
        try {
            $arguments = [
                'Bucket' => $this->getBucket(),
                'Key' => $key,
                'Body' => $data,
                'ACL' => $this->getAcl($acl)
            ];

            if (!empty($contentType)) {
                $arguments['ContentType'] = $contentType;
            }

            $r = $this->getS3Client()->putObject($arguments);

            return $r->get('ObjectURL');
        } catch (Exception $e) {
            return false;
        }
    }

    public function copy($sourceFile, $destFile, $acl = null)
    {
        try {
            $r = $this->getS3Client()->copyObject([
                'Bucket' => $this->getBucket(),
                'Key' => $destFile,
                'CopySource' => $this->getBucket() . '/' . $sourceFile,
                'ACL' => $this->getAcl($acl)
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($dir, $filename)
    {
        try {
            $r = $this->getS3Client()->deleteObject([
                'Bucket' => $this->getBucket(),
                'Key' => $dir . '/' . $filename
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteBatch($files = [])
    {
        try {
            if (!is_array($files)) {
                $files = [$files];
            }
            $r = $this->getS3Client()->deleteObjects([
                'Bucket' => $this->getBucket(),
                'Objects' => $files
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function garbageCollection()
    {
        $dir = "s3://" . $this->getBucket() . "/";

        $this->getS3Client()->registerStreamWrapper();
        if (is_dir($dir) && ($dh = opendir($dir))) {
            while (($file = readdir($dh)) !== false) {
                $file;
            }
            closedir($dh);
        }
    }

    public function getPreSignedUrl($key, $filename = null, $period = '+10 minutes')
    {
        try {
            $filename = !is_null($filename) ? $filename : $key;
            $command = $this->getS3Client()->getCommand('GetObject', array(
                'Bucket' => $this->getBucket(),
                'Key' => $key,
                'ResponseContentDisposition' => 'attachment; filename="' . $filename . '"'
            ));

            $signedUrl = $command->createPresignedUrl($period);
            if ($signedUrl) {
                return $signedUrl;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    private function getAcl($acl)
    {
        switch ($acl) {
            case self::$PRIVATE_ACL:
                return CannedAcl::PRIVATE_ACCESS;
                break;
            default:
                return CannedAcl::PUBLIC_READ;
                break;
        }
    }
}
