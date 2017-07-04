<?php

namespace kowap\lightgallery;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

class LightGalleryWidget extends \yii\base\Widget
{
    public $containerClass = 'k-ld';
    public $options = [];
    public $items = [];


    public function init()
    {
        $this->registerClientScript();
    }

    public function run()
    {
        return $this->renderItems();
    }

    public function renderItems()
    {
        $items = [];
        if (count($this->items) > 0) {
            foreach ($this->items as $item) {
                $items[] = $this->renderItem($item);
            }
        }
        return Html::tag('div', implode("\n", array_filter($items)), ['class' => $this->containerClass, 'id' => $this->id]);
    }

    public function renderItem($item)
    {
        $src = ArrayHelper::getValue($item, 'src');
        $thumb = ArrayHelper::getValue($item, 'thumb');
        return Html::a(Html::img($thumb), $src);
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        LightGalleryAsset::register($view);
        $options = Json::encode($this->options);
        $js = '$("#' . $this->id . '").lightGallery(' . $options . ');';
        $view->registerJs($js);
        $this->addCss();
    }

    public function addCss()
    {
        $css = "
            .k-ld a img {
                padding: 4px;
                position: relative;
                cursor: pointer;
                width: 183px;
                overflow: hidden;
            }
            .k-ld a{
                border-bottom: none;
                margin: 0 1px 1px 0;
                transition: all 0.4s ease 0.1s;
            }
        ";
        $this->getView()->registerCss($css);

    }
}