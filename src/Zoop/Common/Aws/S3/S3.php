<?php

namespace Zoop\Common\Aws\S3;

use \Exception;
use Aws\Common\Aws;
use Aws\S3\Enum\CannedAcl;
use Aws\S3\S3Client;
use Guzzle\Service\Resource\Model;

/**
 *
 * @author Josh
 */
class S3
{
    private $s3Client;
    private $key;
    private $secret;
    private $bucket;
    const PUBLIC_ACL = 'public';
    const PRIVATE_ACL = 'private';

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

    /**
     * Retreive an object from S3
     *
     * @param string $key
     * @return Model
     * @throws Exception
     */
    public function get($key)
    {
        try {
            $query = [
                'Bucket' => $this->getBucket(),
                'Key' => $key
            ];

            return $this->getS3Client()->getObject($query);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Save an object to S3
     *
     * @param string $key
     * @param string $data
     * @param string $acl
     * @param string $contentType
     * @return Model
     * @throws Exception
     */
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

            return $this->getS3Client()->putObject($arguments);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Copy resources within the same bucket
     *
     * @param string $sourceFile
     * @param string $destFile
     * @param string $acl
     * @return Model
     * @throws Exception
     */
    public function copy($sourceFile, $destFile, $acl = null)
    {
        try {
            return $this->getS3Client()->copyObject([
                'Bucket' => $this->getBucket(),
                'Key' => $destFile,
                'CopySource' => $this->getBucket() . DIRECTORY_SEPARATOR . $sourceFile,
                'ACL' => $this->getAcl($acl)
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *
     * @param string $key
     * @return Model
     * @throws Exception
     */
    public function delete($key)
    {
        try {
            return $this->getS3Client()->deleteObject([
                'Bucket' => $this->getBucket(),
                'Key' => $key
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *
     * @param array $files
     * @return Model
     * @throws Exception
     */
    public function batchDelete($files = [])
    {
        try {
            if (!is_array($files)) {
                $files = ['Key' => $files];
            }

            return $this->getS3Client()->deleteObjects([
                'Bucket' => $this->getBucket(),
                'Objects' => $this->formatBatchArray($files)
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *
     */
    public function garbageCollection($dir = '')
    {
        $s3 = "s3://" . $this->getBucket() . DIRECTORY_SEPARATOR . $dir;

        $this->getS3Client()->registerStreamWrapper();
        if (is_dir($s3) && ($dh = opendir($s3))) {
            while (($file = readdir($dh)) !== false) {
                unlink($file);
            }
            closedir($dh);
        }
    }

    /**
     *
     * @param string $key
     * @param string $filename
     * @param string $period
     * @return string|boolean
     * @throws Exception
     */
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
            throw new Exception($e->getMessage());
        }
        return false;
    }

    private function formatBatchArray($array = [])
    {
        $formattedArray = [];
        foreach ($array as $key => $val) {
            $formattedArray[$key] = isset($val['Key']) ? $val['Key'] : ['Key' => $val];
        }
        return $formattedArray;
    }

    /**
     *
     * @param string $acl
     * @return string
     */
    private function getAcl($acl)
    {
        switch ($acl) {
            case self::PRIVATE_ACL:
                return CannedAcl::PRIVATE_ACCESS;
                break;
            default:
                return CannedAcl::PUBLIC_READ;
                break;
        }
    }
}
