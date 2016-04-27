<?php
/**
 * lottery  header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6912 2007-09-02 02:23:45Z drbyte $
 */
  

try { 
 
  $nologin = '0' ;//不登陆抽奖 1 为开启 0位关闭 
  $error = false;
  $ip = zen_get_ip_address();
  if($_POST['action']  == 1){
    if($_SESSION['customer_id'] == ''){
        $data['messages'] = 'You have to sign in and participate in the lottery';
        echo json_encode($data);
        exit();
    }     
/*
    //读取每个人抽奖次数
    $readeverynum = 'Select count(*) as count From zen_prizew_log where customerid = '.$_SESSION['customer_id'];
    $result =  $db->Execute($readeverynum);

    if($result->fields['count'] >= 1){
        $data['messages'] = 'Your lucky draw has run out!';
        echo json_encode($data);
        exit();
    }*/
    
    $zen_prize =  "select * from zen_prizew";
    $result =  $db->Execute($zen_prize);
    $k = -1;
    $nowdate = date("Y-m-d H:i:s");

    while(!$result->EOF){
       $k++;
        //prize表示奖项内容，v表示中奖几率(若数组中七个奖项的v的总和为100，如果v的值为1，则代表中奖几率为1%，依此类推)
        
        //大奖总是在最后抽到的
        if(strtotime($result->fields['time']) < strtotime($nowdate)){
            $probability = $result->fields['v'];
        }
        else{
             $probability = $result->fields['v'];
        }

        $prize_arr[$k] = array(
            'id' =>$result->fields['id'],
            'prize' => $result->fields['prize'],
            'v' => $probability,
            'time' =>$result->fields['time'],
            'type' => $result->fields['type'],
            'condition' => $result->fields['condition'],
            'messages' => $result->fields['messages'],

        );
        //计算是否还有奖品 
        $prize_count += $prize_arr[$k]['v'] ;
        $result->MoveNext();
    }

        if($prize_count == 0){
            $data['messages'] = 'Prizes have been drawn!';
            echo json_encode($data);
            exit();   
        }

        foreach ($prize_arr as $k=>$v) {
                $arr[$v['id']] = $v['v'];
        }
        require(DIR_WS_CLASSES . 'lottery.php');
        $lottery = new lottery;

        $prize_id = $lottery->getRand($arr); //根据概率获取奖项id 
        foreach($prize_arr as $k=>$v){ //获取前端奖项位置
            if($v['id'] == $prize_id){
             $prize_site = $k;
             break;
            }
        }
        $res = $prize_arr[$prize_id - 1]; //中奖项 
        //更新数据库奖品数

        $updateprizenum  = "update zen_prizew set v=v-1 where id =".$prize_id;
        $result =  $db->Execute($updateprizenum);
        //判断是否是优惠劵  优惠劵直接发放
        if($res['type'] == 'coupon'){
              $func  = array(
                'juanamout' => $res['prize'],
                'fullcouponf' =>$res['condition'],
              );
              $couponreslut = $lottery->virtualgoods($func);
        }
        if(!$result->EOF){
          if($nologin  == 1){
                //没有登陆抽奖
                $insert_log_sql = "INSERT INTO `zen_prizew_log` (`drawtime`, `prizew_id`, `customerid`,`ip`,`log`) VALUES ('".$nowdate."', '".$prize_id."', '0','".$ip."','".$couponreslut."')";
                $log_result = $db->Execute($insert_log_sql);
          
                if(!$log_result->EOF){
                     $data['prize_name'] = $res['prize'];
                     $data['prize_site'] = $prize_site;//前端奖项从-1开始
                     $data['prize_id'] = $prize_id;
                     $data['prize_alert'] = $res['messages'];
                     echo json_encode($data);
                }
                else{
                     $data['messages'] = 'error';
                     echo json_encode($data);
                     exit(); 
                }

          }
          else{
                //插入抽奖记录
                $insert_log_sql = "INSERT INTO `zen_prizew_log` (`drawtime`, `prizew_id`, `customerid`,`log`) VALUES ('".$nowdate."', '".$prize_id."', '".$_SESSION['customer_id']."','".$couponreslut."')";
                $log_result = $db->Execute($insert_log_sql);
                if(!$log_result->EOF){
                     $data['prize_name'] = $res['prize'];
                     $data['prize_site'] = $prize_site;//前端奖项从-1开始
                     $data['prize_id'] = $prize_id;
                     $data['prize_alert'] = $res['messages'];
                     echo json_encode($data);
                }
                else{
                     $data['messages'] = 'error';
                     echo json_encode($data);
                     exit(); 
                }
          }
        
        }
      
        zen_exit();
  } 
  else{
    require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
    $breadcrumb->add('lottery');
  }


} catch (Exception $e) {
    
}
