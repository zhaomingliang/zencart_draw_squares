<?php
/**
 * File contains the lottery class ("lottery")
 *
 * @package classes
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson  Fri Jun 1 14:21:21 2012 +0000 Modified in v1.5.1 $
 */
/**
 * lottery class
 *
 * Handles all lottery functions
 *
 * @package classes
 */
class lottery extends base {
	  function getRand($proArr) {
            $data = '';
            $proSum = array_sum($proArr); //概率数组的总概率精度 

            foreach ($proArr as $k => $v) { //概率数组循环
                $randNum = mt_rand(1, $proSum);
                if ($randNum <= $v) {
                    $data = $k;
                    break;
                } else {
                    $proSum -= $v;
                }
            }
            unset($proArr);

            return $data;
        }
       
}