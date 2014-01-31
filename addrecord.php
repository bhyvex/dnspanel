<?php
require_once 'header.inc.php';

$token=trim(escapeshellarg($_REQUEST["txtToken"])," '");
$acctnum=trim(escapeshellarg($_REQUEST["txtAcct"])," '");
$domainid=trim(escapeshellarg($_REQUEST["txtDomain"])," '");
$name=trim(escapeshellarg($_REQUEST["txtName"])," '");
$type=trim(escapeshellarg($_REQUEST["txtType"])," '");
$data=trim(escapeshellarg($_REQUEST["txtData"])," '");
$priority=trim(escapeshellarg($_REQUEST["txtPriority"])," '");
$TTL=trim(escapeshellarg($_REQUEST["txtTTL"])," '");
$comment=trim(escapeshellarg($_REQUEST["txtComment"])," '");

$resp=shell_exec('curl -X POST -i -k -d \'{ "records":[ { "name":"'.$name.'", "type":"'.$type.'", "data":"'.$data.'"'.(empty($TTL)?'':', "ttl":'.$TTL).(empty($priority)?'':', "priority":'.$priority).(empty($comment)?'':', "comment":"'.$comment.'"').' } ] }\' -H "X-Auth-Token: '.$token.'" -H "Content-Type: application/json" https://dns.api.rackspacecloud.com/v1.0/'.$acctnum.'/domains/'.$domainid.'/records 2>&1');
?>
<p>Add record request submitted</p>
<button name="btnBack" type="reset" onClick="history.go(-1);">Back</button>
<?php
//debugging output
echo "<hr/>Raw response:<br/>";

echo "<div style=\"border: 1px solid #000; height: 9em; overflow: auto; margin: 0.5em;\">";
echo nl2br($resp);
echo "</div>";

require_once 'footer.inc.php';