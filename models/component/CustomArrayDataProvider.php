<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\component;

use app\models\helper\PaginationHeader;
use yii\data\ArrayDataProvider;

/**
 * Description of CustomArrayDataProvider
 *
 * @author aqge
 */
class CustomArrayDataProvider extends ArrayDataProvider {

    //put your code here

    public $curentPage;
    public $pageCount;
    public $totalCount;

    public function __construct($config = []) {
        parent::__construct($config);

        $pagination = new PaginationHeader();
        $pagination->setCurrentpage($this->curentPage);
        $pagination->setPagecount($this->pageCount);
        $pagination->setTotalcount($this->totalCount);
    }

}
