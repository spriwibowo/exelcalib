<?php

namespace app\models\helper;


Class StringFormat {

    public static function stringCut($txt, $length) {
        $desc = '';
        $txt = str_replace('/', '/ ', $txt);
        $txt = str_replace('.', '. ', $txt);
        $txt = str_replace(',', ', ', $txt);

        if (strlen($txt) > $length) {
            $perkata = explode(' ', $txt);

            foreach ($perkata as $txtitem) {

                if ($txtitem != '') {

                    if (strlen($txtitem) > $length)
                        $txtitem = substr($txtitem, 0, $length);

                    $desc = $desc . ' ' . $txtitem;
                    if (strlen($desc) >= $length) {
                        $desc = $desc . '.. ';
                        break;
                    }
                }
            }
        } else
            $desc = $txt;

        return $desc;
    }

}
