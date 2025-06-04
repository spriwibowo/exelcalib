<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\helper;

use Yii;

/**
 * Description of PaginationHeader, Untuk menset
 *
 * @author aqge
 */
class PaginationHeader {

    //put your code here

    private static $_hackedVar = [];

    /** menambahkan item baru dalam response header
     * 
     * @param type $key
     * @param type $value
     */
    public function addHeaderValue($key, $value) { 
        $headers->set( $key, $value );
    }
    
    /** untuk overwrite item header yang sudah ada
     * 
     * @param type $key
     * @param type $value
     */
    public function setHeaderValue($key, $value) {
        $headers = Yii::$app->response->headers;
        self::$_hackedVar = json_decode($headers['hacked'], true);
        self::$_hackedVar[$key] = $value;

        $headers->set('hacked', json_encode(self::$_hackedVar));
    }

    /** overwrite Item Heder curent Page
     * 
     * @param type $page
     */
    public function setCurrentpage($page) {
        $this->setHeaderValue('x-pagination-current-page', $page);
    }

    
    /** overWrite item header x-pagination-pagecount
     * 
     * @param type $count
     */
    public function setPagecount($count) {
        $this->setHeaderValue('x-pagination-page-count', $count);
    }
    
    /** overWrite item header x-pagination-pagecount
     * 
     * @param type $count
     */
    public function setTotalcount($count) {
        $this->setHeaderValue('x-pagination-total-count', $count);
    }

}
