<?php

namespace Zoop\Common\Test\Aws\S3;

use \Exception;
use Zoop\Common\Test\AbstractTest;
use Zoop\Common\Aws\S3\S3 as S3Client;

class S3Test extends AbstractTest
{
    protected static $s3;

    public function testDefaultPut()
    {
        $filename = uniqid() . '.txt';
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');
        $r = $this->getS3()->put($filename, $data);

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $r);
        return $filename;
    }

    /**
     * @depends testDefaultPut
     */
    public function testGet($filename)
    {
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');

        $r = $this->getS3()->get($filename);

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $r);
        $this->assertEquals($data, $r->get('Body'));
    }

    public function testCopy()
    {
        $filename1 = uniqid() . '.txt';
        $filename2 = uniqid() . '.txt';
        
        //put the object
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');
        $r = $this->getS3()->put($filename1, $data);

        //copy the uploaded object
        $r = $this->getS3()->copy($filename1, $filename2);
        $this->assertNotEmpty($r);

        //get the copied object
        $r = $this->getS3()->get($filename2);
        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $r);
        $this->assertEquals($data, $r->get('Body'));
        
        return [
            $filename1,
            $filename2
        ];
    }

    /**
     * @depends testCopy
     */
    public function testBatchDelete($files)
    {
        $r = $this->getS3()->batchDelete($files);
        $this->assertNotEmpty($r);

        try {
            $r = $this->getS3()->get($files[0]);
        } catch (Exception $ex) {
            $this->assertInstanceOf('\Exception', $ex);
        }
    }

    public function testContentTypePut()
    {
        $filename = uniqid() . '.txt';
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');
        $r = $this->getS3()->put($filename, $data, S3Client::PUBLIC_ACL, 'text/css');

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $r);
    }

    public function testPrivateAclPut()
    {
        $filename = uniqid() . '.txt';
        $data = file_get_contents(__DIR__ . '/../Assets/test.txt');
        $r = $this->getS3()->put($filename, $data, S3Client::PRIVATE_ACL);

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
        if (!isset(self::$s3)) {
            $config = $this->getApplicationServiceLocator()->get('config')['zoop']['aws'];

            self::$s3 = new S3Client($config['key'], $config['secret'], $config['s3']['buckets']['test']);
        }
        return self::$s3;
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
