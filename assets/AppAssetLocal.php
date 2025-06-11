<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAssetLocal extends AssetBundle
{
    public $basePath = '@webroot/vendor-assets';
    public $baseUrl = '@web/vendor-assets';

    public $css = [
        'bootstrap/css/bootstrap.min.css',
        'fontawesome/css/all.min.css',
        'select2/css/select2.min.css',
    ];

    public $js = [
        'bootstrap/js/bootstrap.bundle.min.js',
        'select2/js/select2.min.js',
    ];

    public $depends = []; // kosongkan agar tidak tarik bawaan seperti jQuery dari CDN
}
