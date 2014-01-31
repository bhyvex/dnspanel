<?php

require_once 'header.inc.php';

$token=trim(escapeshellarg($_REQUEST["txtToken"])," '");
$acctnum=trim(escapeshellarg($_REQUEST["txtAcct"])," '");
$name=trim(escapeshellarg($_REQUEST["txtName"])," '");
$TTL=trim(escapeshellarg($_REQUEST["txtTTL"])," '");
$email=trim(escapeshellarg($_REQUEST["txtEMail"])," '");
$comment=trim(escapeshellarg($_REQUEST["txtComment"])," '");

$resp=shell_exec('curl -X POST -i -k -d \'{"domains":[{"name":"'.$name.'","emailAddress":"'.$email.'"'.(empty($TTL)?'':', "ttl":'.$TTL).(empty($comment)?'':', "comment":"'.$comment.'"').'}]}\' -H "X-Auth-Token: '.$token.'" -H "Content-Type: application/json" https://dns.api.rackspacecloud.com/v1.0/'.$acctnum.'/domains 2>&1');
?>
<p>Add domain request submitted</p>
<button name="btnBack" type="reset" onClick="history.go(-1);">Back</button>
<?php
//debugging output
echo "<hr/>Raw response:<br/>";

echo "<div style=\"border: 1px solid #000; height: 9em; overflow: auto; margin: 0.5em;\">";
echo nl2br($resp);
echo "</div>";

require_once 'footer.inc.php';
