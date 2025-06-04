<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\helper;

use Yii;

/**
 * Description of DataMenu
 *
 * @author aqge
 */
class HelperData {

    public static function ResponseNotFound($message = 'Object not found: 200') {
        return [
            "name" => "Not Found",
            "message" => $message,
            "code" => 0,
            "status" => 404,
            "type" => "yii\\web\\NotFoundHttpException"
        ];
    }

    public static function ErrorField($errors) {
        $data = array();
        foreach ($errors as $att => $item) {
            $data[] = array(
                'field' => $att,
                'message' => $item[0]
            );
        }
        return $data;
    }

    public static function ListCompGroupColor() {
        return array(
            1 => '#f85149',
            2 => '#1a920b',
            3 => '#fe9600',
            4 => '#ffeb3b',
            5 => '#539bf5',
            6 => '#d03592',
            7 => '#adbac7',
            8 => '#009688',
            9 => '#8bc34a',
            10 => '#d1bcf9',
            11 => '#fb5c6e',
            12 => '#bef5cb',
            13 => '#e36209',
            14 => '#0366d6',
            15 => '#f9826c',
            16 => '#f692ce',
            17 => '#959da5',
            18 => '#fff5b1',
            19 => '#79d4cf',
            20 => '#fedbf0',
        );
    }

    public static function ArrayComoGroupColor() {
        $data = array();
        $list = self::ListCompGroupColor();
        foreach ($list as $key => $item) {
            $data[] = array(
                'value' => $key,
                'label' => $item,
            );
        }
        return $data;
    }

    public static function ErrorCode($code) {

        $code = (empty($code)) ? 404 : $code;

        Yii::$app->response->statusCode = $code;
        $response = array(
            'code' => $code,
            'message' => '',
            'status' => $code,
        );
        switch ($code) {
            case 401:
                $response['message'] = "Login failure.  Try logging out and back in.  Password are ONLY used when posting.";
                break;
            case 400:
                $response['message'] = "Invalid request.  You may have exceeded your rate limit.";
                break;
            case 404:
                $response['message'] = "Not found.  This shouldn't happen.  Please let me know what happened using the feedback link above.";
                break;
            case 405:
                $response['message'] = "Data Not found.  This shouldn't happen.  Try another values.";
                break;

            case 500:
                $response['message'] = "Our servers replied with an error. Hopefully they'll be OK soon!";
                break;
            case 502:
                $response['message'] = "Our servers may be down or being upgraded. Hopefully they'll be OK soon!";
                break;
            case 503:
                $response['message'] = "Our service unavailable. Hopefully they'll be OK soon!";
                break;
            default:
                break;
        }

        return $response;
    }

    /**
     * Converts a number to its roman presentation.
     * */
    public static function numberToRoman($num) {
        // Be sure to convert the given parameter into an integer
        $n = intval($num);
        $result = '';

        // Declare a lookup array that we will use to traverse the number: 
        $lookup = array(
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        );

        foreach ($lookup as $roman => $value) {
            // Look for number of matches
            $matches = intval($n / $value);

            // Concatenate characters
            $result .= str_repeat($roman, $matches);

            // Substract that from the number 
            $n = $n % $value;
        }

        return $result;
    }

    public static function contains($str, array $arr) {
        foreach ($arr as $a) {
            if (stripos($str, $a) !== false)
                return true;
        }
        return false;
    }

//    
//    public static function HeaderCustom($provider){
//        $headers = Yii::$app->response->headers;
//        $headers->add('y-pagination-current-page', $provider->pagination->page + 1000);
//        $headers->add('y-pagination-page-count', $provider->pagination->pageCount);
//    }
    
    
    
    public static function getServiceToTipe($id_service) {

        if ($id_service >= 10000) {
            $tipe = 'tipem';
        } elseif ($id_service >= 9000) {
            $tipe = 'tipea';
        } elseif ($id_service >= 8000) {
            $tipe = 'tiper';
        } elseif ($id_service >= 7000) {
            $tipe = 'tipeh';
        } elseif ($id_service >= 6000) {
            $tipe = 'tipeo';
        } elseif ($id_service >= 5000) {
            $tipe = 'tipeb';
        } elseif ($id_service >= 4000) {
            $tipe = 'tipet';
        } elseif ($id_service >= 3000) {
            $tipe = 'tipel';
        } elseif ($id_service >= 2000) {
            $tipe = 'tipek';
        } elseif ($id_service >= 1000) {
            $tipe = 'tipe';
        } else {
            $tipe = 'tipep';
        }
        return $tipe;
    }
    
//    public function getDashboardQuePreffix() {
//        $preffix = array(
//            'tipep' => tipe puskesmas,
//            'tipe' => tipe rs,
//            'tipeb' => tipe bpfk,
//            'tipel' => tipe labkes,
//            'tipet' => tipe transfusi,
//            'tipek' => tipe klinik,
//            'tipea' => tipe apotik,
//            'tipeo' => tipe optik,
//            'tipeh' => tipe klinik hukum,
//            'tiper' => tipe traditional,
//            'tipem' => tipe praktik mandiri
//        );
//
//        if (isset($this->tipe) && isset($preffix[$this->tipe->enum_term]))
//            return $preffix[$this->tipe->enum_term];
//        
//        return 0;
//    }
}
