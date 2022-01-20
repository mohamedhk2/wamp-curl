<?php

namespace Mohamedhk2\WampCurl;

use Couchbase\PathNotFoundException;
use Noodlehaus\Config;
use Noodlehaus\Exception\FileNotFoundException;

final class WampCurl
{
    private function __construct()
    {
    }

    /**
     * @param $wamp_path
     * @param $cacert_local_path
     * @link https://curl.haxx.se/ca/cacert.pem
     *
     * @return array
     * @throws FileNotFoundException
     */
    public static function fix($wamp_path, $cacert_local_path)
    {
        self::check_dir($wamp_path);
        self::check_file($cacert_local_path);
        $wamp_php_bins = "{$wamp_path}\bin\php";
        $wamp_apache_bins = "{$wamp_path}\bin\apache";
        self::check_dir($wamp_php_bins);
        self::check_dir($wamp_apache_bins);
        $curl_cainfo = 'curl.cainfo = "' . $cacert_local_path . '"';
        $php_dirs = glob("{$wamp_php_bins}/*", GLOB_ONLYDIR);
        $apache_dirs = glob("{$wamp_apache_bins}/*", GLOB_ONLYDIR);
        $results = [];
        foreach (array_merge($php_dirs, $apache_dirs) as $dir) {
            /**
             * php path : bin/php/VERSION/php.ini
             * apache path : bin/apache/VERSION/bin/php.ini
             */
            $file_exists = file_exists($path = realpath($dir . DIRECTORY_SEPARATOR . 'php.ini'));
            if (!$file_exists) $file_exists = file_exists($path = $dir . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'php.ini');
            if ($file_exists) {
                $content = file_get_contents($path);
                preg_match('/; *curl\.cainfo *=/', $content, $matches);
                $conf = Config::load($path);
                $curl = $conf->get('curl');
                if (empty($curl) && count($matches)) {
                    $new_content = str_replace($matches[0], $curl_cainfo, $content);
                    copy($path, $backup = "$path.bak_" . date('Ymd') . '_' . uniqid());
                    file_put_contents($path, $new_content);
                    $results[$path] = $backup;
                } else $results[$path] = 'OK';
            } else $results[$path] = 'FileNotFound !';
        }
        return $results;
    }

    /**
     * @param $path
     *
     * @return void
     * @throws PathNotFoundException
     */
    private static function check_dir($path)
    {
        if (!is_dir($path)) throw new PathNotFoundException(" ==> $path <== ");
    }

    /**
     * @param $path
     *
     * @return void
     * @throws FileNotFoundException
     */
    private static function check_file($path)
    {
        if (!file_exists($path)) throw new FileNotFoundException(" ==> $path <== ");
    }
}