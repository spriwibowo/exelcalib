<?php

namespace app\models\helper;

use app\models\component\ExportComponent;
use app\models\component\HzlUtil;

/**
 * Description of ExcelExport
 *
 * @author ASUS
 */
class ExcelExport {

    //put your code here
    public static function run($data, $filename, $column_title = array(), $top_header = array(), $sheet = 'Sheet1') {
        $excel_data = array('excel_title' => [], 'excel_ceils' => []);
        if (count($data) > 0)
            $excel_data = HzlUtil::excelDataFormat($data, $column_title);

        $excel_title = $excel_data['excel_title'];
        $excel_ceils = $excel_data['excel_ceils'];

        $excel_content = array(
            array(
                'sheet_name' => $sheet,
                'sheet_title' => $excel_title,
                'ceils' => $excel_ceils,
//                'freezePane' => 'B2',
                'headerColor' => HzlUtil::getCssClass("header"),
                'headerColumnCssClass' => array(
                    'id' => HzlUtil::getCssClass('blue'),
                    'Status_Description' => HzlUtil::getCssClass('grey'),
                ), //define each column's cssClass for header line only.  You can set as blank.
                'oddCssClass' => HzlUtil::getCssClass("odd"),
                'evenCssClass' => HzlUtil::getCssClass("even"),
                'top_header' => $top_header,
            ),
//            array(
//                'sheet_name' => 'Important Note',
//                'sheet_title' => array("Important Note For Region Template"),
//                'ceils' => array(
//                    array("1.Column Platform,Part,Region must need update.")
//                    , array("2.Column Regional_Status only as Regional_Green,Regional_Yellow,Regional_Red,Regional_Ready.")
//                    , array("3.Column RTS_Date, Master_Desc, Functional_Desc, Commodity, Part_Status are only for your reference, will not be uploaded into NPI tracking system."))
//            ),
        );
        $excel_file = $filename;

        $export_comp = new ExportComponent();

        return $export_comp->export2excel($excel_content, $excel_file);
    }

    //put your code here
    public static function run_sheet($sheets = array(), $filename) {

        if (empty($sheets)) {
            return false;
        }

        $excel_content = array();

        foreach ($sheets as $key => $sheet) {
            $column_title = !empty($sheet['column_title']) ? $sheet['column_title'] : array();
            $data = !empty($sheet['data']) ? $sheet['data'] : array();
            $nomor = $key + 1;
            $sheet_name = !empty($sheet['name']) ? $sheet['name'] : 'Sheet' . $nomor;
            $top_header = !empty($sheet['top_header']) ? $sheet['top_header'] : array();
            $excel_title = array();
            $excel_ceils = array();
            if (!empty($data)) {
                $excel_data = HzlUtil::excelDataFormat($data, $column_title);

                $excel_title = $excel_data['excel_title'];
                $excel_ceils = $excel_data['excel_ceils'];
            }

            $excel_content[] = array(
                'sheet_name' => $sheet_name,
                'sheet_title' => $excel_title,
                'ceils' => $excel_ceils,
                //                'freezePane' => 'B2',
                'headerColor' => HzlUtil::getCssClass("header"),
                'headerColumnCssClass' => array(
                    'id' => HzlUtil::getCssClass('blue'),
                    'Status_Description' => HzlUtil::getCssClass('grey'),
                ), //define each column's cssClass for header line only.  You can set as blank.
                'oddCssClass' => HzlUtil::getCssClass("odd"),
                'evenCssClass' => HzlUtil::getCssClass("even"),
                'top_header' => $top_header,
            );
        }

        $excel_file = $filename;

        $export_comp = new ExportComponent();

        return $export_comp->export2excel($excel_content, $excel_file);
    }
}
