<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=adress_book.<br />
 * Allows customer to manage entries in their address book
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_default.php 5369 2006-12-23 10:55:52Z drbyte $
 */
?>
<div class="centerColumn" >

<h1 id="DefaultHeading">My lucky draw</h1>
 

     

<br class="clearBoth" />
<table width="100%" border="0" cellspacing="0" cellpadding="0"   class="mylucky" >
<tr>
    <td width="5%"><h3>ID</h3></td>
    <td  width="20%"><h3>Lottery time</h3></td>
    <td  width="10%"><h3>prize</h3></td>
    <td  width="10%"><h3>Prize state</h3></td>
     <td  width="30%"><h3>Log</h3></td>
  </tr>
<?php
/**
 * Used to loop thru and display address book entries
 */
  foreach ($myluckyArray as $v) {
?>

  <tr>
    <td><?php 	echo $v['id'];?></td>
    <td><?php 	echo $v['drawtime'];?></td>
    <td><?php 	echo $v['releasestatus'];?></td>
    <td><?php 	echo $v['customerid'];?></td>
    <td><?php 	echo $v['log'];?></td>
  </tr>


<?php
  }
?>
</table>

<style>
.mylucky td{ line-height:30px; }
.mylucky tr:hover{ background:#CCC;}
</style>

<div class="buttonRow back"><?php echo '<a href="' . zen_href_link('lottery', '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>
<br class="clearBoth" />
</div>
