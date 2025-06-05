<?php

namespace backend\components\contenttools\actions;

use Yii;
use Exception;
use yii\base\Action;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\base\InvalidParamException;

/**
 * @author Paweł Bizley Brzozowski
 * @version 1.0
 * @license Apache 2.0
 * https://github.com/bizley-code/yii2-content-tools
 * http://www.yiiframework.com/extension/yii2-content-tools
 *
 * ContentTools was created by Anthony Blackshaw
 * http://getcontenttools.com/
 * https://github.com/GetmeUK/ContentTools
 *
 * Example action prepared for the Yii 2 ContentTools.
 *
 * This action handles the cropping of image.
 *
 * 'crop' parameter is the list of cropping marks positions in order:
 * top, left, bottom, right.
 *
 * Position value can by anything between 0 and 1 so
 * '0,0,1,1' means full image with no cropping and
 * '0.25,0.25,0.75,0.75' means that box half the size of the full image in the
 * center needs to be cropped from it.
 *
 * Cropping is handled by the Imagine library through yii2-imagine extension.
 * JS engine can add '?_ignore=...' part to the url so it should be removed.
 * If 'crop' parameter is not set image should be inserted in the content as-is.
 * Action returns the size, url and alternative description of image (cropped or not).
 */
class InsertAction extends Action
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        try {
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post();
                if (empty($data['url'])) {
                    throw new InvalidParamException('Invalid insert options!');
                }
                $url = trim($data['url']);

                if (substr($url, 0, 1) == '/') {
                    $url = substr($url, 1);
                }
                if (strpos($url, '?_ignore=') !== false) {
                    $url = substr($url, 0, strpos($url, '?_ignore='));
                }
                $url = substr($url, mb_strlen(Yii::$app->params['statics'] . '/'));

                $path = Yii::getAlias('@statics/') . $url;

                $crop = [];
                if (!empty($data['crop'])) {
                    $crop = explode(',', $data['crop']);
                    if (count($crop) !== 4) {
                        throw new InvalidParamException('Invalid crop options!');
                    }
                    foreach ($crop as $c) {
                        if (!is_numeric(trim($c)) || trim($c) < 0 || trim($c) > 1) {
                            throw new InvalidParamException('Invalid crop options!');
                        }
                    }
                }

                if (!empty($crop)) {
                    list($width, $height) = getimagesize($path);

                    $pointX = floor($width * trim($crop[1])); // New box X start
                    $pointY = floor($height * trim($crop[0])); // New box Y start
                    // New image Width
                    $newWidth = floor($width * trim($crop[3]) - $width * trim($crop[1]));
                    // New image Height
                    $newHeight = floor($height * trim($crop[2]) - $height * trim($crop[0]));

                    // Create new Imagin obj
                    $imagine = new \Imagine\Gd\Imagine();
                    // Create new Image Obj
                    $image = $imagine->open($path);

                    // Do actions
                    $image
                        ->crop(new Point($pointX, $pointY), new Box($newWidth, $newHeight))
                        ->save($path);
                }

                list($width, $height) = getimagesize($path);

                return Json::encode([
                    'size' => [$width, $height],
                    'url' => Yii::$app->params['statics'] . '/' . $url,
                    'alt' => basename($url)
                ]);
            }
        } catch (Exception $e) {
            return Json::encode(['errors' => [$e->getMessage()]]);
        }
    }
}