<?php

namespace drexlerux\sweetalert;

use yii\base\Widget;
use yii\helpers\Json;

/**
 * SweetAlert widget
 */
class SweetAlert extends Widget
{
    /**
     * Info type of the alert
     */
    const TYPE_INFO = 'info';
    /**
     * Error type of the alert
     */
    const TYPE_ERROR = 'error';
    /**
     * Error type of the alert
     */
    const TYPE_DANGER = 'error';
    /**
     * Success type of the alert
     */
    const TYPE_SUCCESS = 'success';
    /**
     * Warning type of the alert
     */
    const TYPE_WARNING = 'warning';

    /**
     * @var string the type of the alert to be displayed. One of the `TYPE_` constants.
     * Defaults to `TYPE_SUCCESS`
     */
    public $type = self::TYPE_SUCCESS;
    /**
     * @var bool If set to true, the user can dismiss the modal by clicking outside it.
     */
    public $allowOutsideClick = true;
    /**
     * @var int Auto close timer of the modal. Set in ms (milliseconds). default - 1,5 second
     */
    public $timer = 0;
    /**
     * Plugin options
     * @var array
     */
    public $options = [];

    /**
     * Render alert
     * @return string|void
     */
    public function run()
    {
        $this->registerAssets();
        parent::run();
    }

    /**
     * Register client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        SweetAlertAsset::register($view);
        $js = "swal({$this->getOptions()});";
        $view->registerJs($js);
    }

    /**
     * Get plugin options
     * @return string
     */
    public function getOptions()
    {
        $this->options['allowOutsideClick'] = $this->allowOutsideClick;
        $this->options['timer'] = $this->timer;
        $this->options['type'] = $this->type;
        return Json::encode($this->options);
    }
}
