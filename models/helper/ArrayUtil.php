<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\models\helper;

/**
 * Description of ArrayUtil
 *
 * @author aqge
 */
class ArrayUtil {
    //put your code here

    /** Membuang key dari source array , mengganit dengan index linear
     * 
     * @param type $source  array sumber dengan key tidak/bukan index linear
     * @return type array
     */
    public static function stripper($source) {
        $data = [];
        
        foreach ($source as $key => $value)    
            $data[] = $value;        

        return $data;
    }
    
     public static function stripAsString($source) {
        $data = [];

        foreach ($source as $key => $value) {
            $row = [];
            foreach ($value as $sbkey => $subvalue)
                $row[$sbkey] = (string) $subvalue;

            $data[] = $row;
        }

        return $data;
    }

}
