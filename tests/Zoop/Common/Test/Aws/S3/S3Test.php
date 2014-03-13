<?php

namespace Zoop\Common\Test\S3;

use \Exception;
use Zoop\Common\Test\BaseTest;
use Zoop\Common\Aws\S3\S3 as S3Client;

class S3Test extends BaseTest
{
    const FILENAME_1 = 'test1.txt';
    const FILENAME_2 = 'test2.txt';

    protected $s3;

    public function testDefaultPut()
    {
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');
        $r = $this->getS3()->put(self::FILENAME_1, $data);

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $r);
    }

    public function testGet()
    {
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');

        $r = $this->getS3()->get(self::FILENAME_1);

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $r);
        $this->assertEquals($data, $r->get('Body'));
    }

    public function testCopy()
    {
        //put the object
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');
        $r = $this->getS3()->put(self::FILENAME_1, $data);

        //copy the uploaded object
        $r = $this->getS3()->copy(self::FILENAME_1, self::FILENAME_2);
        $this->assertNotEmpty($r);

        //get the copied object
        $r = $this->getS3()->get(self::FILENAME_2);
        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $r);
        $this->assertEquals($data, $r->get('Body'));
    }

    public function testBatchDelete()
    {
        $r = $this->getS3()->batchDelete([self::FILENAME_1, self::FILENAME_2]);
        $this->assertNotEmpty($r);

        try {
            $r = $this->getS3()->get(self::FILENAME_2);
        } catch (Exception $ex) {
            $this->assertInstanceOf('\Exception', $ex);
        }
    }

    public function testContentTypePut()
    {
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');
        $r = $this->getS3()->put(self::FILENAME_1, $data, S3Client::PUBLIC_ACL, 'text/css');

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $r);
    }

    public function testPrivateAclPut()
    {
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');
        $r = $this->getS3()->put(self::FILENAME_1, $data, S3Client::PRIVATE_ACL);

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $r);
        $url = $r->get('ObjectURL');

        $this->setExpectedException('PHPUnit_Framework_Error_Warning');
        $r = file_get_contents($url);
    }

    /**
     * @return S3Client
     */
    protected function getS3()
    {
        if (!isset($this->s3)) {
            $config = $this->getApplicationServiceLocator()->get('config')['zoop']['aws'];

            $this->s3 = new S3Client($config['key'], $config['secret'], $config['s3']['buckets']['test']);
        }
        return $this->s3;
    }

    public function initFilename()
    {
        if (!isset($this->filename)) {
            $filename = uniqid() . '.txt';
            $this->setFilename($filename);
        }
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }
}
