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

    /**
     * @param $arr array
     * @param $arr['juanamout'] string 劵金额
     * @param $arr['fullcouponf'] string 满多少送
     * @return log
     * 生成优惠劵
     */
    function virtualgoods($arr){
          global $db;
          $juan = $this->random('6','all','0');
          $juanamout = $arr['juanamout'];
          $fullcouponf = $arr['fullcouponf'];
          $startdate = date("Y-m-d H:i:s");

          $insertsql ="INSERT INTO `coupons` (`coupon_id`,`coupon_type`,`coupon_code`,`coupon_amount`,
            `coupon_minimum_order`,`coupon_start_date`,`coupon_expire_date`,`uses_per_coupon`,
            `uses_per_user`,`restrict_to_products`,`restrict_to_categories`,`restrict_to_customers`,
            `coupon_active`,`date_created`,`date_modified`,`coupon_zone_restriction`
          )
          VALUES
            (
              '".$juan."',
              'F',
              '".$juan."',
              '".$juanamout."',
              '".$fullcouponf."',
              '".$startdate."',
              '',
              '0',
              '1',
              NULL,
              NULL,
              '".$_SESSION['customer_id']."',
              'Y',
              '".$startdate."',
              '".$startdate."',
              '0'
          )";
       $couponfresult =  $db->Execute($insertsql);
       if($couponfresult) {
            //插入到个人的抽奖记录
           $return =  $this->insertmylog($juan);
        }

        return $return;
    }

    /**
     * 插入文字
     */
    function insertmylog($coupon = ''){
          $log = "Your coupon is:(".$coupon."), Please purchase the time to copy the use of";
          return $log;

    }

    /**
       * 随机字符
       * @param number $length 长度
       * @param string $type 类型
       * @param number $convert 转换大小写
       * @return string
    */
   function random($length=6, $type='string', $convert=0){
       
          $config = array(
              'number'=>'1234567890',
              'letter'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
              'string'=>'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
              'all'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
          );
           
          if(!isset($config[$type])) $type = 'string';
          $string = $config[$type];
           
          $code = '';
          $strlen = strlen($string) -1;
          for($i = 0; $i < $length; $i++){
              $code .= $string{mt_rand(0, $strlen)};
          }
          if(!empty($convert)){
              $code = ($convert > 0)? strtoupper($code) : strtolower($code);
          }
          return $code;
    }
}