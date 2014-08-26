<?php

namespace Zoop\Common\Ftp;

use \Exception;

class Sftp
{
    private $connection;
    private $sftp;

    public function __construct($host, $port = 22)
    {
        if (is_callable('ssh2_connect')) {
            $this->setConnection(ssh2_connect($host, $port));
        } else {
            throw new Exception("ssh2 is not installed. Please install php-pecl-ssh2");
        }
    }

    public function login($username, $password)
    {
        if (!@ssh2_auth_password($this->getConnection(), $username, $password)) {
            throw new Exception("Could not authenticate with username $username and password $password.");
        }

        $this->setSftp(@ssh2_sftp($this->getConnection()));
    }

    public function upload($localFile, $remoteFile)
    {
        $stream = @fopen('ssh2.sftp://' . $this->getSftp() . $remoteFile, 'w');

        if (!$stream) {
            throw new Exception("Could not open file: $remoteFile");
        }

        $dataToSend = @file_get_contents($localFile);
        if ($dataToSend === false) {
            throw new Exception("Could not open local file: $localFile.");
        }

        if (@fwrite($stream, $dataToSend) === false) {
            throw new Exception("Could not send data from file: $localFile.");
        }

        @fclose($stream);
    }

    /**
     *
     * @return ssh2_connect
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     *
     * @return ssh2_sftp
     */
    public function getSftp()
    {
        return $this->sftp;
    }

    /**
     *
     * @param ssh2_connect $connection
     */
    public function setConnection($connection)
    {
        if (!$connection) {
            throw new Exception("Could not connect");
        }
        $this->connection = $connection;
    }

    /**
     *
     * @param ssh2_sftp $sftp
     */
    public function setSftp($sftp)
    {
        if (!$sftp) {
            throw new Exception("Could not initialize SFTP subsystem.");
        }
        $this->sftp = $sftp;
    }
}
