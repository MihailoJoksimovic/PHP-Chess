<?php
require_once dirname(__FILE__) . "/../common/config/config.php";

$uci = new \Libs\UCI();

$uci->startGame();

var_dump($uci->getBestMove(array('g1f3', 'g8f6', 'b1c31+ASF')));