<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\component;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use Yii;
use yii\db\Exception;

/**
 * Description of HzlUtil
 *
 * @author ASUS
 */
class HzlUtil {

    //put your code here


    public static function excelColumnName($index) {
        --$index;
        if ($index >= 0 && $index < 26)
            return chr(ord('A') + $index);
        else if ($index > 25)
            return (self::excelColumnName($index / 26)) . (self::excelColumnName($index % 26 + 1));
        else
            throw new Exception("Invalid Column # " . ($index + 1));
    }

//    $column_title = ['name_user'=>'Name User']
    public static function excelDataFormat($data, $column_title = array()) {
        $show_column = array();
        $show_title = array();
        $new_arr = array();
        if (!empty($column_title)) {
            $show_column = array_keys($column_title);
            $show_title = array_values($column_title);
        }

        for ($i = 0; $i < count($data); $i++) {
            if (!empty($show_column)) {
                $each_arr_show = array_intersect_key($data[$i], /* main array */ array_flip($show_column)
                );

                $each_arr = array_replace(array_flip($show_column), $each_arr_show);
            } else {
                $each_arr = $data[$i];
            }

            $new_arr[] = array_values($each_arr); //返回所有键值
        }

        if (empty($show_title)) {
            $show_title = array_keys($data[0]); //返回所有索引值
        }


        return array('excel_title' => $show_title, 'excel_ceils' => $new_arr);
    }

    public static function getCssClass($code = '') {
        $cssClass = array(
            'red' => array('color' => 'FFFFFF', 'background' => 'FF0000'),
            'pink' => array('color' => '', 'background' => 'FFCCCC'),
            'green' => array('color' => '', 'background' => 'CCFF99'),
            'lightgreen' => array('color' => '', 'background' => 'CCFFCC'),
            'yellow' => array('color' => '', 'background' => 'FFFF99'),
            'white' => array('color' => '', 'background' => 'FFFFFF'),
            'grey' => array('color' => 'FFFFFF', 'background' => '808080'),
            'greywhite' => array('color' => 'FFFFFF', 'background' => '808080'),
            'blue' => array('color' => 'FFFFFF', 'background' => 'blue'),
            'lightblue' => array('color' => 'FFFFFF', 'background' => '6666FF'),
            'notice' => array('color' => '514721', 'background' => 'FFF6BF'),
            'header' => array('color' => 'FFFFFF', 'background' => '519CC6'),
            'odd' => array('color' => '', 'background' => 'E5F1F4'),
            'even' => array('color' => '', 'background' => 'F8F8F8'),
        );

        if (empty($code))
            return $cssClass;
        elseif (isset($cssClass[$code]))
            return $cssClass[$code];
        else
            return [];
    }

    public static function save2Excel($excel_content, $excel_file, $excel_props = array(
        'creator' => 'WWSP Tool',
        'title' => 'WWSP_Tracking EXPORT EXCEL',
        'subject' => 'WWSP_Tracking EXPORT EXCEL',
        'desc' => 'WWSP_Tracking EXPORT EXCEL',
        'keywords' => 'WWSP Tool Generated Excel, Author: Scott Huang',
        'category' => 'WWSP_Tracking EXPORT EXCEL')) {

        if (!is_array($excel_content)) {
            return FALSE;
        }
        if (empty($excel_file)) {
            return FALSE;
        }
        $objPHPExcel = new PHPExcel();
        $objProps = $objPHPExcel->getProperties();
        $objProps->setCreator($excel_props['creator']);
        $objProps->setLastModifiedBy($excel_props['creator']);
        $objProps->setTitle($excel_props['title']);
        $objProps->setSubject($excel_props['subject']);
        $objProps->setDescription($excel_props['desc']);
        $objProps->setKeywords($excel_props['keywords']);
        $objProps->setCategory($excel_props['category']);

        $style_obj = new PHPExcel_Style();
        $style_array = array(
//            'borders' => array(
//                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
//                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
//                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
//                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
//            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap' => true
            ),
        );
        $style_obj->applyFromArray($style_array);

//开始执行EXCEL数据导出
        for ($i = 0; $i < count($excel_content); $i++) {
            $each_sheet_content = $excel_content[$i];
            if ($i == 0) {
//默认会创建一个sheet页，故不需在创建
                $objPHPExcel->setActiveSheetIndex(intval(0));
                $current_sheet = $objPHPExcel->getActiveSheet();
            } else {
//创建sheet
                $objPHPExcel->createSheet();
                $current_sheet = $objPHPExcel->getSheet($i);
            }
//设置sheet title
            $current_sheet->setTitle(str_replace(array('/', '*', '?', '\\', ':', '[', ']'), array('_', '_', '_', '_', '_', '_', '_'), substr($each_sheet_content['sheet_name'], 0, 30))); //add by Scott
            $current_sheet->getColumnDimension()->setAutoSize(true); //Scott, set column autosize
//设置sheet当前页的标题

            $fistRow = 1;
            
            if (array_key_exists('top_header', $each_sheet_content) && !empty($each_sheet_content['top_header'])) {
                foreach ($each_sheet_content['top_header'] as $top_title=>$top_value){
                    $current_sheet->setCellValueByColumnAndRow(0, $fistRow, $top_title);
                    $current_sheet->setCellValueByColumnAndRow(1, $fistRow, $top_value);
                    
                    $fistRow++;
                }
                $fistRow+=1;
            }



            $_columnIndex = 'A';
            if(!empty($each_sheet_content['sheet_title'])){
                $lineRange = "A".$fistRow.":" . HzlUtil::excelColumnName(count($each_sheet_content['sheet_title'])) . $fistRow;
                $current_sheet->setSharedStyle($style_obj, $lineRange);
            }
            

            if (array_key_exists('sheet_title', $each_sheet_content) && !empty($each_sheet_content['sheet_title'])) {
                //header color
                if (array_key_exists('headerColor', $each_sheet_content) && is_array($each_sheet_content['headerColor']) and ! empty($each_sheet_content['headerColor'])) {
                    if (isset($each_sheet_content['headerColor']["color"]) and $each_sheet_content['headerColor']['color'])
                        $current_sheet->getStyle($lineRange)->getFont()->getColor()->setARGB($each_sheet_content['headerColor']['color']);
                    //background
                    if (isset($each_sheet_content['headerColor']["background"]) and $each_sheet_content['headerColor']['background']) {
                        $current_sheet->getStyle($lineRange)->getFill()->getStartColor()->setRGB($each_sheet_content['headerColor']["background"]);
                        $current_sheet->getStyle($lineRange)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    }
                }

                for ($j = 0; $j < count($each_sheet_content['sheet_title']); $j++) {
                    $current_sheet->setCellValueByColumnAndRow($j, $fistRow, $each_sheet_content['sheet_title'][$j]);
                    //start handle hearder column css
                    if (array_key_exists('headerColumnCssClass', $each_sheet_content)) {
                        if (isset($each_sheet_content["headerColumnCssClass"][$each_sheet_content['sheet_title'][$j]])) {
                            $tempStyle = $each_sheet_content["headerColumnCssClass"][$each_sheet_content['sheet_title'][$j]];
                            $tempColumn = HzlUtil::excelColumnName($j + 1) . $fistRow;
                            if (isset($tempStyle["color"]) and $tempStyle['color'])
                                $current_sheet->getStyle($tempColumn)->getFont()->getColor()->setARGB($tempStyle['color']);
                            //background
                            if (isset($tempStyle["background"]) and $tempStyle['background']) {
                                $current_sheet->getStyle($tempColumn)->getFill()->getStartColor()->setRGB($tempStyle["background"]);
                                $current_sheet->getStyle($tempColumn)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            }
                        }
                    }
                    $current_sheet->getColumnDimension($_columnIndex)->setAutoSize(true); //
                    $_columnIndex++;
                }
            }
            if (array_key_exists('freezePane', $each_sheet_content) && !empty($each_sheet_content['freezePane'])) {
                $current_sheet->freezePane($each_sheet_content['freezePane']);
            }
//写入sheet页面内容
            if (array_key_exists('ceils', $each_sheet_content) && !empty($each_sheet_content['ceils'])) {
                for ($row = 0; $row < count($each_sheet_content['ceils']); $row++) {
                    //setting row css
                    $lineRange = "A" . ($fistRow + $row + 1) . ":" . HzlUtil::excelColumnName(count($each_sheet_content['ceils'][$row])) . ($fistRow + $row + 1);
                    if (($row + 1) % 2 == 1 and isset($each_sheet_content["oddCssClass"])) {
                        if ($each_sheet_content["oddCssClass"]["color"])
                            $current_sheet->getStyle($lineRange)->getFont()->getColor()->setARGB($each_sheet_content["oddCssClass"]["color"]);
                        //background
                        if ($each_sheet_content["oddCssClass"]["background"]) {
                            $current_sheet->getStyle($lineRange)->getFill()->getStartColor()->setRGB($each_sheet_content["oddCssClass"]["background"]);
                            $current_sheet->getStyle($lineRange)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        }
                    } else if (($row + 1) % 2 == 0 and isset($each_sheet_content["evenCssClass"])) {
//                        echo "even",$row,"<BR>";
                        if ($each_sheet_content["evenCssClass"]["color"])
                            $current_sheet->getStyle($lineRange)->getFont()->getColor()->setARGB($each_sheet_content["evenCssClass"]["color"]);
                        //background
                        if ($each_sheet_content["evenCssClass"]["background"]) {
                            $current_sheet->getStyle($lineRange)->getFill()->getStartColor()->setRGB($each_sheet_content["evenCssClass"]["background"]);
                            $current_sheet->getStyle($lineRange)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        }
                    }
                    //write content
                    for ($l = 0; $l < count($each_sheet_content['ceils'][$row]); $l++) {
                        $current_sheet->setCellValueByColumnAndRow($l, $fistRow + $row + 1, $each_sheet_content['ceils'][$row][$l]);
                    }
                }
            }
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $tempDir = Yii::getAlias('@webroot') . '/uploads/temp/';
        if (!is_dir($tempDir)) {
            mkdir(Yii::getAlias('@webroot') . '/uploads'); //need 2 steps to avoid error
            mkdir($tempDir);
            chmod($tempDir, 0755);
// the default implementation makes it under 777 permission, which you could possibly change recursively before deployment, but here's less of a headache in case you don't
        }
        $file_name = $tempDir . str_replace(array('/', '*', '?', '\\', ':', '[', ']'), array('_', '_', '_', '_', '_', '_', '_'), $excel_file) . '-' . date('Ymd-His') . '.xlsx';

        $objWriter->save($file_name);
        return $file_name;
//        if (!file_exists($file_name)) {
//            HzlUtil::setMsg("Error", "File not exist");
//            return false;
//        }
    }

}
