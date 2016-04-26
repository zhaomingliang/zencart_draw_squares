<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account.<br />
 * Displays previous orders and options to change various Customer Account settings
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Sun Aug 5 20:48:10 2012 -0400 Modified in v1.5.1 $
 */
?>
 <div id="lottery">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td class="lottery-unit lottery-unit-0"><img src="/includes/templates/template_default/images/lottery/1.png" /></td>
              <td class="lottery-unit lottery-unit-1"><img src="/includes/templates/template_default/images/lottery/2.png" /></td>
              <td class="lottery-unit lottery-unit-2"><img src="/includes/templates/template_default/images/lottery/4.png" /></td>
              <td class="lottery-unit lottery-unit-3"><img src="/includes/templates/template_default/images/lottery/3.png" /></td>
            </tr>
            <tr>
              <td class="lottery-unit lottery-unit-11"><img src="/includes/templates/template_default/images/lottery/7.png" /></td>
              <td colspan="2" rowspan="2"><a href="javascript:void(0);"></a></td>
              <td class="lottery-unit lottery-unit-4"><img src="/includes/templates/template_default/images/lottery/5.png" /></td>
            </tr>
            <tr>
              <td class="lottery-unit lottery-unit-10"><img src="/includes/templates/template_default/images/lottery/1.png" /></td>
              <td class="lottery-unit lottery-unit-5"><img src="/includes/templates/template_default/images/lottery/6.png" /></td>
            </tr>
            <tr>
              <td class="lottery-unit lottery-unit-9"><img src="/includes/templates/template_default/images/lottery/3.png" /></td>
              <td class="lottery-unit lottery-unit-8"><img src="/includes/templates/template_default/images/lottery/6.png" /></td>
              <td class="lottery-unit lottery-unit-7"><img src="/includes/templates/template_default/images/lottery/8.png" /></td>
              <td class="lottery-unit lottery-unit-6"><img src="/includes/templates/template_default/images/lottery/7.png" /></td>
            </tr>
          </table>
    </div>
     <style type="text/css">
            #lottery{width:574px;height:584px;margin:20px auto;background:url(/includes/templates/template_default/images/lottery/bg.jpg) no-repeat;padding:50px 55px;}
            #lottery table td{width:142px;height:142px;text-align:center;vertical-align:middle;font-size:24px;color:#333;font-index:-999}
            #lottery table td a{width:284px;height:284px;line-height:150px;display:block;text-decoration:none;}
            #lottery table td.active{background-color:#ea0000;}

    </style> 
    <script type="text/javascript">
            var lottery = {
                index: 0, //当前转动到哪个位置，起点位置
                count: 0, //总共有多少个位置
                timer: 0, //setTimeout的ID，用clearTimeout清除
                speed: 20, //初始转动速度
                times: 0, //转动次数
                cycle: 50, //转动基本次数：即至少需要转动多少次再进入抽奖环节
                prize: 0, //中奖位置
                init: function(id) {
                    if ($("#" + id).find(".lottery-unit").length > 0) {
                        $lottery = $("#" + id);
                        $units = $lottery.find(".lottery-unit");
                        this.obj = $lottery;
                        this.count = $units.length;
                        $lottery.find(".lottery-unit-" + this.index).addClass("active");
                    }
                },
                roll: function() {
                    var index = this.index;
                    var count = this.count;
                    var lottery = this.obj;
                    $(lottery).find(".lottery-unit-" + index).removeClass("active");
                    index += 1;
                    if (index > count - 1) {
                        index = 0;
                    }
                    $(lottery).find(".lottery-unit-" + index).addClass("active");
                    this.index = index;
                    return false;
                },
                stop: function(index) {
                    this.prize = index;
                    return false;
                }
            };

            function roll() {
                lottery.times += 1;
                lottery.roll();
                var prize_site = $("#lottery").attr("prize_site");
                if (lottery.times > lottery.cycle + 10 && lottery.index == prize_site) {
                    var prize_id = $("#lottery").attr("prize_id");
                    var prize_name = $("#lottery").attr("prize_name");
                    alert("前端中奖位置："+prize_site+"\n"+"中奖名称："+prize_name+"\n中奖id："+prize_id)
                    clearTimeout(lottery.timer);
                    lottery.prize = -1;
                    lottery.times = 0;
                    click = false;

                } else {
                    if (lottery.times < lottery.cycle) {
                        lottery.speed -= 10;
                    } else if (lottery.times == lottery.cycle) {
                        var index = Math.random() * (lottery.count) | 0;
                        lottery.prize = index;
                    } else {
                        if (lottery.times > lottery.cycle + 10 && ((lottery.prize == 0 && lottery.index == 7) || lottery.prize == lottery.index + 1)) {
                            lottery.speed += 110;
                        } else {
                            lottery.speed += 20;
                        }
                    }
                    if (lottery.speed < 40) {
                        lottery.speed = 40;
                    }
                    lottery.timer = setTimeout(roll, lottery.speed);
                }
                return false;
            }

            var click = false;

            $(function() {
                lottery.init('lottery');
                $("#lottery a").click(function() {
                     if (click) {
                        return false;
                    } else {
                        lottery.speed = 100;
                        $.post("/index.php?main_page=lottery", {action:1,securityToken:"<?Php echo $_SESSION['securityToken'] ?>"}, function(data) { //获取奖品，也可以在这里判断是否登陆状态
                            $("#lottery").attr("prize_site", data.prize_site);
                            $("#lottery").attr("prize_id", data.prize_id);
                            $("#lottery").attr("prize_name", data.prize_name);
                            roll();
                            click = true;
                            return false;
                        }, "json")
                    }
                });
            })
</script>