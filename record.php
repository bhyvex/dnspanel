<?php

require_once 'header.inc.php';

//List properties of record
//Tasks - update, back
$token=trim(escapeshellarg($_REQUEST["txtToken"])," '");
$acctnum=trim(escapeshellarg($_REQUEST["txtAcct"])," '");
$domainid=trim(escapeshellarg($_REQUEST["txtDomain"])," '");
$recid=trim(escapeshellarg($_REQUEST["txtRecID"])," '");

//get record
$resp=shell_exec('curl -s -k -H \'X-Auth-Token: '.$token.'\' \'https://dns.api.rackspacecloud.com/v1.0/'.$acctnum.'/domains/'.$domainid.'/records/'.$recid.'\' 2>&1');

$arrResp=json_decode(trim($resp),true);
$arrRecord=$arrResp;
?>

<!--
name, includes domain
type A,AAAA,CNAME,NS,TXT,SRV
data
priority
id, auto
ttl, auto
comment
-->
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form class="form-horizontal" method="get" action="modrecord.php" name="frmModRecord" role="form">

    <legend>Record <?php echo $arrRecord["id"]; ?>:</legend>
    <div class="form-group">
    <label for="txtAcct" class="col-sm-2 control-label">Account</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" id="txtAcct" name="txtAcct" placeholder="<?php echo $acctnum; ?>" value="<?php echo $acctnum; ?>">
	</div>
    </div>
    <div class="form-group">
	<label for="txtToken" class="col-sm-2 control-label">Auth Token</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" id="txtToken" name="txtToken" placeholder="<?php echo $token; ?>" value="<?php echo $token; ?>">
	</div>
    </div>

    <div class="form-group">
    <label for="txtAcct" class="col-sm-2 control-label">Domain ID</label>
    <div class="col-sm-10">
    <input type="text" readonly class="form-control" id="txtDomain" name="txtDomain" value="<?php echo $domainid; ?>"/>
    </div>
    </div>

    <div class="form-group">
    <label for="txtId" class="col-sm-2 control-label">Record ID</label>
    <div class="col-sm-10">
    <input type="text" readonly class="form-control" id="txtId" name="txtId" value="<?php echo $arrRecord["id"]; ?>"/>
    </div>
    </div>

    <div class="form-group">
    <label for="txtName" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
    <input type="text" readonly class="form-control" id="txtName" name="txtName" value="<?php echo $arrRecord["name"]; ?>"/>
    </div>
    </div>

    <div class="form-group">
    <label for="txtType" class="col-sm-2 control-label">Type</label>
    <div class="col-sm-10">
    <input type="text" readonly class="form-control" id="txtType" name="txtType" value="<?php echo $arrRecord["type"]; ?>"/>
    </div>
    </div>

    <div class="form-group">
    <label for="txtData" class="col-sm-2 control-label">Data</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" id="txtData" name="txtData" value="<?php echo $arrRecord["data"]; ?>"/>
    </div>
    </div>

    <div class="form-group">
    <label for="txtPriority" class="col-sm-2 control-label">Priority</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" id="txtPriority" name="txtPriority" value="<?php echo $arrRecord["priority"]; ?>"/>
    </div>
    </div>

    <div class="form-group">
    <label for="txtTTL" class="col-sm-2 control-label">TTL</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" id="txtTTL" name="txtTTL" value="<?php echo $arrRecord["ttl"]; ?>"/>
    </div>
    </div>

    <div class="form-group">
    <label for="txtComment" class="col-sm-2 control-label">Comment</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" id="txtComment" name="txtComment" value="<?php echo $arrRecord["comment"]; ?>"/>
    </div>
    </div>

    <div class="form-group">
    <label for="txtCreated" class="col-sm-2 control-label">Created</label>
    <div class="col-sm-10">
    <?php echo $arrRecord["created"]; ?>
    </div>
    </div>

    <div class="form-group">
    <label for="txtUpdated" class="col-sm-2 control-label">Updated</label>
    <div class="col-sm-10">
    <?php echo $arrRecord["updated"]; ?>
    </div>
    </div>

<button name="btnSubmit" value="Mod">Modify</button>
<button name="btnBack" type="reset" onClick="history.go(-1);">Back</button>
</form>
<?php
//debugging output
echo "<hr/>Raw response:<br/>";
echo "<div style=\"border: 1px solid #000; height: 9em; overflow: auto; margin: 0.5em;\">";
echo nl2br($resp);
echo "</div>";
echo "<pre style=\"border: 1px solid #000; height: 9em; overflow: auto; margin: 0.5em;\">";
var_export($arrResp);
echo "</pre>\n<br/>";

require_once 'footer.inc.php';