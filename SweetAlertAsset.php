<?php

namespace drexlerux\sweetalert;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class SweetAlertAsset
 */
class SweetAlertAsset extends AssetBundle
{

    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     * A source asset file is a file that is part of your source code repository of your Web application.
     */
    public $sourcePath = '@bower/bootstrap-sweetalert/dist';

    /**
     * @var array list of JavaScript files that this bundle contains. Each JavaScript file can be
     * specified in one of the following formats:
     */
    public $js = [
        ['sweetalert.js', 'position' => View::POS_END]
    ];

    /**
     * @var array list of CSS files that this bundle contains. Each CSS file can be specified
     * in one of the three formats as explained in [[js]].
     */
    public $css = [
        'sweetalert.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $overrideConfirm = true;

    public function init()
    {
        parent::init();
        if ($this->overrideConfirm) {
            self::overrideConfirm();
        }
    }

    public static function overrideConfirm()
    {
        Yii::$app->view->registerJs('
            // workaround for bootstrap modal
            $.fn.modal.Constructor.prototype.enforceFocus = function () {};
            yii.confirm = function (message, ok, cancel) {
                swal({
                    title: message,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "'.Yii::t('app', 'Yes').'",
                    cancelButtonText: "'.Yii::t('app', 'No').'",
                },
                function(isConfirm){
                    if (isConfirm) {
                        !ok || ok();
                    } else {
                        !cancel || cancel();
                    }
                });
            }
        ');
    }

}
