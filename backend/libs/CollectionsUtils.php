<?php

namespace app\libs;

use DateTime;
use yii\web\Session;
use ZipArchive;

/**
 * Description of CollectionsUtils
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class CollectionsUtils
{

    const SESS_HASH_KEY = 'collection_dowload.hashes';

    static public function createZip(int $userId, int $collectionId, int $updatedAt, array $imagesArr) {
        $filenamePrefix = "{$userId}_{$collectionId}_{$updatedAt}";
        $zipFilename = $filenamePrefix . '.zip';
        $zipFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipFilename;

        if (file_exists($zipFile)) {
            return ['filename' => $zipFilename, 'file' => $zipFile];
        }
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE);
        foreach ($imagesArr as $k => $file) {
            $tmpFilename = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filenamePrefix . rand(1, 1000) . "_{$k}_" . '.tmp';
            if (!copy($file, $tmpFilename)) {
                return false;
            }
            $ext = self::guessFileExt($tmpFilename);
            if ($ext === false) {
                return false;
            }
            $zip->addFile($tmpFilename, ($k + 1) . '.' . $ext);
        }
        $zip->close();
        return ['filename' => $zipFilename, 'file' => $zipFile];
    }

    /**
     * Guess file extension
     * @param type $filename
     * @return boolean|string
     */
    static public function guessFileExt($filename) {
        $allowed = [IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif'];
        $type = exif_imagetype($filename);
        $k = array_search($type, array_keys($allowed));
        if ($k !== false) {
            return $allowed[$type];
        }
        return false;
    }

    /**
     * 
     * @param Session $sess
     * @param int $userId
     * @param int $collectionId
     * @param string $file
     * @param string $filenameame
     * @return array
     */
    static public function createDownloadToken(Session $sess, int $userId, int $collectionId, string $file, string $filenameame) {

        $hash = md5($userId . $collectionId . $file . $filenameame);
        $hashes = [];
        if ($sess->has(self::SESS_HASH_KEY)) {
            $hashes = $sess->get(self::SESS_HASH_KEY);
        }
        $dt = new DateTime();
        $hashes[$hash . $collectionId] = ['time' => $dt->getTimestamp(), 'file' => $file, 'filename' => $filenameame];
        $sess->set(self::SESS_HASH_KEY, $hashes);
        return $hash;
    }

    /**
     * Returns an array with resource to file if passed token is valid else return false
     * @param Session $sess
     * @param string $hash
     * @param int $collectionId
     * @return boolean|array
     */
    static public function getDownloadFileByToken(Session $sess, string $hash, int $collectionId) {
        if (!$sess->has(self::SESS_HASH_KEY)) {
            return false;
        }
        $token = $sess->get(self::SESS_HASH_KEY)[$hash . $collectionId] ?? false;
        if ($token === false || !file_exists($token['file'])) {
            return false;
        }
        $resource = fopen($token['file'], 'r');
        $token['resorce'] = $resource;
        return $token;
    }

}
