<?php
/**
 * User: ms
 * Date: 14.09.15
 * Time: 20:09
 */
use Mvg\HttpPostNewsTicker;
error_reporting(E_ALL);


require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$response = (new HttpPostNewsTicker())->doPostRequest();
$newsTicker = new \ Mvg\Parser\Html\NewsTicker($response);
var_dump($newsTicker->getInterferences());
