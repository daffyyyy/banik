<?php

namespace App\Models;

use CodeIgniter\Model;

class BansModel extends Model
{
    protected $table = 'credentials';
    protected $allowedFields = ['user_id', 'bans_host', 'bans_user', 'bans_password', 'bans_database', 'file_name'];
    protected $afterInsert = ['afterInsert'];
    static protected $path = '/var/www/bansy.banik.pl/public_html';
    static protected $lowerUserName;
    static protected $userName;

    public function __construct(string $userName = "")
    {
        parent::__construct();
        self::$lowerUserName = strtolower($userName);
        self::$userName = $userName;
    }

    protected function afterInsert(array $data)
    {
        $db = \Config\Database::connect();
        $db->query("CREATE USER '{$data['data']['bans_user']}'@'%' IDENTIFIED BY '{$data['data']['bans_password']}';");
        $db->query("CREATE DATABASE {$data['data']['bans_user']}");
        $db->query("GRANT ALL ON {$data['data']['bans_user']}.* TO '{$data['data']['bans_user']}'@'%'");
    }

    static function changePassword(array $data)
    {
        $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $db = \Config\Database::connect();
        $db->query("USE {$data['bans_database']};");
        $db->query("UPDATE `amx_webadmins` SET `password` = '{$data['new_password']}' WHERE `id` = '1';");
    }

    private static function custom_copy(string $src, string $dst)
    {
        // open the source directory 
        $dir = opendir($src);

        // Make the destination directory if not exist 
        @mkdir($dst);

        // Loop through the files in source directory 
        foreach (scandir($src) as $file) {

            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {

                    // Recursively calling custom copy function 
                    // for sub directory  
                    self::custom_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    private static function rrmdir(string $dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                        self::rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                    else
                        unlink($dir . DIRECTORY_SEPARATOR . $object);
                }
            }
            rmdir($dir);
        }
    }


    static function editConfig(array $data)
    {
        mkdir(self::$path . '/' . self::$lowerUserName);
        self::custom_copy(self::$path . '/daffyy', self::$path . '/' . self::$lowerUserName);

        self::rrmdir(self::$path . '/' . self::$lowerUserName . '/__plugin__');
        unlink(self::$path . '/' . self::$lowerUserName . '/import.sql');

        $file = file_get_contents(self::$path . '/' . self::$lowerUserName . '/include/db.config.inc.php');

        $str = str_replace([
            'CHANGE_USER',
            'CHANGE_DBUSER',
            'CHANGE_DBPASS',
            'CHANGE_DBDB'
        ], [
            self::$lowerUserName,
            $data['bans_user'],
            $data['bans_password'],
            $data['bans_database']
        ], $file);

        $db = \Config\Database::connect();

        $nickName = self::$userName;

        file_put_contents(self::$path . '/' . self::$lowerUserName . '/include/db.config.inc.php', $str);

        self::importDB($data['bans_database']);

        $password = password_hash($data['user_password'], PASSWORD_DEFAULT);

        $db->query("USE {$data['bans_database']};");
        $db->query("UPDATE `amx_webadmins` SET username = '{$nickName}', password = '{$password}', email = '{$data['user_email']}';");
    }

    private static function importDB(string $database)
    {
        $db = \Config\Database::connect();
        $db->query("USE $database;");
        $op_data = "";

        $lines = file(self::$path . '/daffyy/import.sql');
        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '') //This IF Remove Comment Inside SQL FILE
            {
                continue;
            }
            $op_data .= $line;
            if (substr(trim($line), -1, 1) == ';') //Breack Line Upto ';' NEW QUERY
            {
                $db->query($op_data);
                $op_data = '';
            }
        }
    }

    static function createZIP(array $data)
    {
        helper('text');
        helper('download');
        $zip = new \ZipArchive();

        $bans = new BansModel();
        $user = $bans->where('user_id', session()->get('user_id'))
            ->first();

        if (empty($user['file_name'])) {
            $fileTmp = random_string('alnum', 64);

            self::custom_copy(self::$path . '/daffyy/__plugin__/__template__', self::$path . "/daffyy/__plugin__/$fileTmp");

            $file = file_get_contents(self::$path . "/daffyy/__plugin__/$fileTmp/configs/sql.cfg");

            $str = str_replace([
                'CHANGE_DBHOST',
                'CHANGE_DBUSER',
                'CHANGE_DBPASS',
                'CHANGE_DBDB'
            ], [
                $data['bans_host'],
                $data['bans_user'],
                $data['bans_password'],
                $data['bans_database']
            ], $file);

            file_put_contents(self::$path . "/daffyy/__plugin__/$fileTmp/configs/sql.cfg", $str);

            $zip->open(self::$path . "/daffyy/__plugin__/" . $fileTmp . ".zip", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(self::$path . "/daffyy/__plugin__/$fileTmp/"),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );
            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen("/daffyy/__plugin__/$fileTmp") + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
            $bans->where('user_id', session()->get('user_id'))->set(['file_name' => $fileTmp])->update();
        } else {
            $fileTmp = $user['file_name'];
        }

        self::downloadZip($fileTmp);
    }

    static function downloadZip($file_name)
    {
        $file_name = self::$path . "/daffyy/__plugin__/" . $file_name . ".zip";

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
        header('Content-Length: ' . filesize($file_name));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($file_name);

        //     $file_name = self::$path . "/daffyy/__plugin__/" . $file_name . ".zip";
        //     $mime = 'application/octet-stream';
        //     header('Pragma: public');
        //     header('Expires: 0');
        //     header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        //     header('Cache-Control: private', false);
        //     header('Content-Type: ' . $mime);
        //     header("Content-Length: " . (string) filesize($file_name));
        //     header('Content-Disposition: inline; filename="' . basename($file_name) . '"');
        //     header('Content-Transfer-Encoding: binary');

        //     if ($file = fopen($file_name, 'rb')) {
        //         while (!feof($file) and connection_status() == 0) {
        //             print fread($file, 1024 * 8);
        //             flush();
        //             @ob_flush();
        //         }
        //         fclose($file);
        //     }
        // }
    }
}
