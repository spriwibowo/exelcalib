<?php

namespace app\models\component;

use yii\web\HeaderCollection;
use yii\web\HeadersAlreadySentException;
use yii\web\Response;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WriteableResponse
 *
 * @author aqge
 */
class WriteableResponse extends Response {

    //put your code here

    protected $_myheaders;

    public function init() {
        parent::init();
        $this->_myheaders = $this->getHeaders();

        $this->on('beforeSend', function ($event) {
            if ($event->sender->format != 'html') {

                $hacked = $event->sender->headers->get('hacked');

//              hanya BUKAN HTML
                if ($hacked) {
                    $hackedHeader = json_decode($hacked);

                    foreach ($hackedHeader as $key => $value)
                        $event->sender->headers->set($key, $value);

                   $event->sender->headers->remove('hacked');
                }
            }
        });
    }

    protected function sendHeaders() {
        if (headers_sent($file, $line)) {
            throw new HeadersAlreadySentException($file, $line);
        }

        if ($this->_myheaders) {
            foreach ($this->getMyHeaders() as $name => $values) {
                $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
                // set replace for first occurrence of header but false afterwards to allow multiple
                $replace = true;
                foreach ($values as $value) {
                    header("$name: $value", $replace);
                    $replace = false;
                }
            }
        }
        $statusCode = $this->getStatusCode();
        header("HTTP/{$this->version} {$statusCode} {$this->statusText}");
        $this->sendCookies();
    }

    public function getMyHeaders() {
        if ($this->_myheaders === null) {
            $this->_myheaders = new HeaderCollection();
        }

        return $this->_myheaders;
    }

}
