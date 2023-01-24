<?php
/**
 * CdnFreeAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome;

/**
 * Class CdnFreeAssetBundle
 * @package rmrevin\yii\fontawesome
 */
class CdnFreeAssetBundle extends \yii\web\AssetBundle
{
    /**
     * @inherit
     */
    public $css = [
        '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css',
    ];
}
