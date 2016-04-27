<?php
/**
 * my_lottery  header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6912 2007-09-02 02:23:45Z drbyte $
 */
  

$zco_notifier->notify('NOTIFY_HEADER_START_ADDRESS_BOOK');

if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add('Lottery', zen_href_link('lottery', '', 'SSL'));
$breadcrumb->add('My Lucky Log');

$log_query = "SELECT *
                    FROM   zen_prizew_log
                    WHERE  customerid = :customersID
                    ORDER BY id desc";

$log_query = $db->bindVars($log_query, ':customersID', $_SESSION['customer_id'], 'integer');
$mylucky = $db->Execute($log_query);

while (!$mylucky->EOF) {
  $myluckyArray[] = array(
  'prizew_id'=>$mylucky->fields['prizew_id'],
  'drawtime'=>$mylucky->fields['drawtime'],
  'id'=>$mylucky->fields['id'],
  'customerid'=>$mylucky->fields['customerid'],
  'releasestatus'=>$mylucky->fields['releasestatus'],
  'log'=> $mylucky->fields['log'],
  );

  $mylucky->MoveNext();
}
