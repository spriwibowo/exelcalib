<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\component;

use Yii;

/**
 * Description of ExportBehavior
 *
 * @author ASUS
 */
class ExportComponent {

    public $prop1;
    private $_prop2;

    public function getProp2() {
        return $this->_prop2;
    }

    public function setProp2($value) {
        $this->_prop2 = $value;
    }

    public function export2Excel($excel_content, $excel_file
    , $excel_props = array('creator' => 'WWSP Tool'
        , 'title' => 'WWSP_Tracking EXPORT EXCEL'
        , 'subject' => 'WWSP_Tracking EXPORT EXCEL'
        , 'desc' => 'WWSP_Tracking EXPORT EXCEL'
        , 'keywords' => 'WWSP Tool Generated Excel, Author: Scott Huang'
        , 'category' => 'WWSP_Tracking EXPORT EXCEL')) {
        if (!is_array($excel_content)) {
            return FALSE;
        }
        if (empty($excel_file)) {
            return FALSE;
        }

        $excelName = HzlUtil::save2Excel($excel_content, $excel_file, $excel_props);
        if ($excelName) {
            $params = array_merge(['site/download'], array("file_name" => basename($excelName),
                "file_type" => 'excel',
                'deleteAfterDownload' => true)
            );
            //$url = Yii::$app->urlManager->createAbsoluteUrl($params);
            $url = \yii\helpers\Url::toRoute( $params, 'https');

            return array(
                'url' => $url
            );
//            return $this->owner->redirect([Url::to('site/download'), "file_name" => 'temp/' . basename($excelName)
//                        , "file_type" => 'excel'
//                        , 'deleteAfterDownload' => true]);
        }
    }

}
