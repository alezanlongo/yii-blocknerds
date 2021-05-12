<?php

namespace common\components;

use Exception;
use Yii;
use yii\base\Component;

/**
 * Description of ImageStorage
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class ImageStorageComponent extends Component
{

    private $storagePath = DIRECTORY_SEPARATOR . 'imageStorage';

    const IMAGE_TYPE_THUMB = 'thumb';
    const IMAGE_TYPE_IMG = 'img';
    private const IMAGE_RAW_NAME = '%s_%s_%s_%s';

    public function __construct($config = []) {
        $this->storagePath = Yii::getAlias('@common') . $this->storagePath;
        if (!is_dir($this->storagePath)) {
            if (!mkdir($this->storagePath, '0755', true)) {
                throw new Exception('storage cannot create the container directory');
            }
        }
        parent::__construct($config);
    }

    /**
     * 
     * @param int $userId
     * @param int $collectionId
     * @param string $externalImageId
     * @param string $fileUrl
     * @param string $type
     * @return string
     * @throws Exception
     */
    public function storeImage(int $userId, int $collectionId, string $externalImageId, string $fileUrl, string $type) {
        if (!in_array($type, [self::IMAGE_TYPE_THUMB, self::IMAGE_TYPE_IMG])) {
            throw new Exception('unknown image type');
        }

        $tmpFile = tempnam(sys_get_temp_dir(), 'img');
        if (!copy($fileUrl, $tmpFile)) {
            throw new Exception('error on copy tmp file');
        }
        $fileExt = $this->guessFileExt($tmpFile);
        if (!$fileExt) {
            throw new Exception('unknown image format');
        }
        $filename = $this->storagePath . DIRECTORY_SEPARATOR . $this->getImageName($userId, $collectionId, $externalImageId, $type) . ".{$fileExt}";
        if (!copy($tmpFile, $filename)) {
            throw new Exception('error on copy file');
        }
        return basename($filename);
    }

    /**
     * 
     * @param string type $filename
     * @param boolean $asResource
     * @return boolean
     */
    public function getImage($filename, bool $asResource = true) {
        if (!$this->fileImageExists($filename)) {
            return false;
        }
        return $asResource ? @fopen($this->storagePath . DIRECTORY_SEPARATOR . $filename, 'r') : $this->storagePath . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * 
     * @param string $filename
     * @return boolean
     */
    public function deleteImage(string $filename) {
        if ($this->fileImageExists($filename)) {
            return unlink($this->storagePath . DIRECTORY_SEPARATOR . $filename);
        }
        return false;
    }

    /**
     * 
     * @param string $filename
     * @return string
     */
    public function fileImageExists(string $filename) {
        return (file_exists($this->storagePath . DIRECTORY_SEPARATOR . $filename));
    }

    /**
     * Guess file extension
     * @param type $file
     * @return boolean|string
     */
    public function guessFileExt($file) {
        $allowed = [IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif'];
        $type = exif_imagetype($file);
        if (in_array($type, array_keys($allowed))) {
            return $allowed[$type];
        }
        return false;
    }

    /**
     * 
     * @param int $userId
     * @param int $collectionId
     * @param string $externalImageId
     * @param string $type
     * @return string
     */
    public function getImageName(int $userId, int $collectionId, string $externalImageId, string $type): string {
        return sprintf(self::IMAGE_RAW_NAME, $userId, $collectionId, $externalImageId, $type);
    }

}
