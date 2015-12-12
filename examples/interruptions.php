<?php
/**
 * User: ms
 * Date: 16.09.15
 * Time: 23:50
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';


use Mvg\RequestHandler\Json\HttpGetInterruptions;

$b = new HttpGetInterruptions();

$r  =$b->doRequest();
print_r($r);