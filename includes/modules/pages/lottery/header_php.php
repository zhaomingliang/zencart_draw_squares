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
  if (!isset($_SESSION['customer_id']) || !$_SESSION['customer_id']) { 
          $_SESSION['navigation']->set_snapshot(); 
          zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL')); 
      } else { 
       
        if (zen_get_customer_validate_session($_SESSION['customer_id']) == false) { 
          $_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_SHIPPING)); 
          zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL')); 
        } 
  }

  $error = false;
  //读取每个人抽奖次数
  $readeverynum = 'Select count(*) as count From zen_prizew_log where customerid = '.$_SESSION['customer_id'];
  $result =  $db->Execute($readeverynum);
  if($result->fields['count'] >= 1){
       echo "<script>alert('Your lucky draw has run out!');</script>";
  }



  if($_POST['action']  == 1){

    $zen_prize =  "select * from zen_prizew";
    $result =  $db->Execute($zen_prize);
    $k = -1;
    $nowdate = date("Y-m-d Y:i:s");

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

        );
        //计算是否还有奖品 
        $prize_count += $prize_arr[$k]['v'] ;
        $result->MoveNext();
    }

        if($prize_count == 0){
            echo "<script>alert('Prizes have been drawn!');</script>";
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
        if(!$result->EOF){
            //插入抽奖记录
            $insert_log_sql = "INSERT INTO `zen_prizew_log` (`drawtime`, `prizew_id`, `customerid`) VALUES ('".$nowdate."', '".$prize_id."', '".$_SESSION['customer_id']."')";
            $log_result = $db->Execute($insert_log_sql);
            if(!$log_result->EOF){
                 $data['prize_name'] = $res['prize'];
                 $data['prize_site'] = $prize_site;//前端奖项从-1开始
                 $data['prize_id'] = $prize_id;
                 echo json_encode($data);
            }
            else{
                 echo '<script>alert("error!");</script>';
                 exit(); 
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
