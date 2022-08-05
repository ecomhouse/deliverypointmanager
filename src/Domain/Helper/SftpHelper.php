<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Helper;

use Exception;

final class SftpHelper
{
    private string $host;
    private string $username;
    private string $password;
    private string $remoteDir;

    public function __construct(
        string $host,
        string $username,
        string $password,
        string $remoteDir
    ) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->remoteDir = $remoteDir;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function downloadFile(): string
    {
        $localDir = $_ENV['FILE_PATH_DIRECTORY'];
        $sftpConnection = $this->connect();
        if (!$dir = opendir("ssh2.sftp://$sftpConnection$this->remoteDir"))
            throw new Exception('Failed to open the directory.');

        $lastFile = null;
        while (($file = readdir($dir)) !== false) {
            $lastFile = $file;
        }
        closedir($dir);

        if (!$remote = fopen("ssh2.sftp://$sftpConnection$this->remoteDir$lastFile", 'r')) {
            throw new Exception("Failed to open remote file: $lastFile\n");
        }

        if (!$local = fopen($localDir . $lastFile, 'w')) {
            throw new Exception("Failed to create local file: $lastFile\n");
        }

        $read = 0;
        $filesize = filesize("ssh2.sftp://$sftpConnection/$this->remoteDir$lastFile");
        while (($read < $filesize) && ($buffer = fread($remote, $filesize - $read))) {
            $read += strlen($buffer);
            if (fwrite($local, $buffer) === FALSE) {
                throw new Exception("Failed to write to local file: $lastFile\n");
            }
        }
        fclose($local);
        fclose($remote);

        return $localDir . $lastFile;
    }

    /**
     * @throws Exception
     */
    private function connect()
    {
        if (!function_exists("ssh2_connect"))
            throw new Exception('Function ssh2_connect does not exist.');

        if (!$connection = ssh2_connect($this->host))
            throw new Exception('Failed to connect.');

        if (!ssh2_auth_password($connection, $this->username, $this->password))
            throw new Exception('Failed to authenticate.');

        if (!$sftpConnection = ssh2_sftp($connection))
            throw new Exception('Failed to create a sftp connection.');

        return $sftpConnection;
    }
}