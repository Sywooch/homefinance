<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class LightroomSingle extends Widget {
    
    var $image_url;
    var $header_title;
    var $toggle_options;

    public function init() {
        if (!isset($this->header_title)) $this->header_title = "Preview";
        if (!isset($this->toggle_options)) $this->toggle_options = [];
        ob_start();
        ob_implicit_flush(false);
    }

    public function run() {
        $block = ob_get_clean();
        if (!$block) {
            $toggle_options = $this->toggle_options;
            $toggle_options['src'] = $this->image_url;
            if (!isset($toggle_options['style'])) $toggle_options['style'] = '';
            $toggle_options['style'] .= 'cursor: pointer;';
            $block = Html::tag('img', '', $toggle_options);
        }
        return $this->render('lightroom-single', [
            'toggle' => $block,
            'header_title' => $this->header_title,
            'image_url' => $this->image_url,
        ]);
    }
}