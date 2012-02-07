<?php
require_once dirname(__FILE__) . "/../common/config/config.php";

$clock = new \Libs\Clock(-5);

$clock->startCounting();

sleep(5);

$clock->stopCounting();

var_dump($clock->getTimeLeft());


die();

$uci = new \Libs\UCI();

$uci->startGame();

var_dump($uci->getBestMove(array('g1f3', 'g8f6', 'b1c31+ASF')));