<?php

require_once 'header.inc.php';

//List records
//Tasks - change, delete, new
//To do:
//Bind import/export
$token=trim(escapeshellarg($_REQUEST["txtToken"])," '");
$acctnum=trim(escapeshellarg($_REQUEST["txtAcct"])," '");
$domainid=trim(escapeshellarg($_REQUEST["txtDomain"])," '");

//get record list
$resp=shell_exec('curl -s -k -H "X-Auth-Token: '.$token.'" https://dns.api.rackspacecloud.com/v1.0/'.$acctnum.'/domains/'.$domainid.' 2>&1');
$arrResp=json_decode(trim($resp),true);
$arrRecordsList=$arrResp["recordsList"];
$arrRecords=$arrRecordsList["records"];

?>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <legend>Domain <?php echo $domainid; ?>:</legend>
    <table class="table table-striped table-condensed table-hover table-responsive">
      <tr><td>Domain Name</td><td><?php echo $arrResp["name"]; ?></td></tr>
      <tr><td>EMail Address</td><td><input type="email" class="form-control" id="txtEMail" name="txtEMail" value="<?php echo $arrResp["emailAddress"]; ?>" /></td></tr>
      <tr><td>TTL</td><td><input type="text" class="form-control" id="txtTTL" name="txtTTL" value="<?php echo $arrResp["ttl"] ?>" /></td></tr>
      <tr><td>Comment</td><td><input type="text" class="form-control" id="txtComment" name="txtComment" value="<?php echo $arrResp["comment"]; ?>" /></td></tr>
      <tr><td>Created</td><td><?php echo $arrResp["created"]; ?></td></tr>
      <tr><td>Updated</td><td><?php echo $arrResp["updated"]; ?></td></tr>
    </table>
    <button value="Update" name="btnUpdate" onClick="moddomain();" >Update</button>
  </div>
</div>

<p></p>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <label>Nameservers:</label>
    <table class="table table-condensed">
<?php
foreach ($arrResp["nameservers"] as $arrNS) {
	echo "<tr><td>".$arrNS["name"]."</td></tr>";
	}
?>
    </table>
  </div>
</div>

<p></p>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <label>Records:</label>
    <table class="table table-striped table-condensed table-hover table-responsive">
<tr><th>Name</th><th>Type</th><th>Content</th><th>TTL</th><th>Priority</th><th>Delete</th></tr>

<?php
foreach ($arrRecords as $arrRecord) {
	echo "<tr><td>"
		."<a href='record.php?txtAcct=".$acctnum."&txtToken=".$token."&txtDomain=".$domainid."&txtRecID=".$arrRecord["id"]."'>".$arrRecord["name"]."</a>"
		."</td><td>".$arrRecord["type"]."</td><td>".$arrRecord["data"]."</td><td>".$arrRecord["ttl"]."</td><td>".$arrRecord["priority"]."</td><td>"
		."<a href='delrecord.php?txtAcct=".$acctnum."&txtToken=".$token."&txtDomain=".$domainid."&txtRecID=".$arrRecord["id"]."&btnSubmit=Remove'><span class=\"glyphicon glyphicon-trash\"></a>"
		."</td></tr>";
	}
?>
    </table>
  </div>
</div>

<!--
name, includes domain
type A,AAAA,CNAME,NS,TXT,SRV,MX
-->
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form class="form-horizontal" method="get" action="addrecord.php" name="frmAddRecord" role="form">
    <legend>Add Record:</legend>
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
	<label for="txtName" class="col-sm-2 control-label">Name</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" id="txtName" name="txtName" placeholder="myrecord.mydomain.com">
	</div>
    </div>
    
    <div class="form-group">
	<label for="txtType" class="col-sm-2 control-label">Type</label>
	<div class="col-sm-10">
    <select class="form-control" id="txtType" name="txtType">
      <option>A</option>
      <option>AAAA</option>
      <option>CNAME</option>
      <option>NS</option>
      <option>TXT</option>
      <option>SRV</option>
      <option>MX</option>
    </select>
	</div>
    </div>

    <div class="form-group">
	<label for="txtData" class="col-sm-2 control-label">Data</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" id="txtData" name="txtData" placeholder="">
	</div>
    </div>

    <div class="form-group">
	<label for="txtPriority" class="col-sm-2 control-label">Priority</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" id="txtPriority" name="txtPriority" placeholder="">
	</div>
    </div>

    <div class="form-group">
	<label for="txtTTL" class="col-sm-2 control-label">TTL</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" id="txtTTL" name="txtTTL" placeholder="86400">
	</div>
    </div>

    <div class="form-group">
	<label for="txtComment" class="col-sm-2 control-label">Comment</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" id="txtComment" name="txtComment" placeholder="">
	</div>
    </div>

    <div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
    <button type="reset" class="btn btn-danger">Clear</button>
	</div>
    </div>
    <input type="hidden" id="refreshed" value="no">
    <div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-default">Add</button>
	</div>
    </div>
    </form>
  </div>
</div>
<script>
function moddomain() {
window.location = "moddomain.php?txtToken=<?php echo $token; ?>&txtAcct=<?php echo $acctnum; ?>&txtDomain=<?php echo $domainid; ?>&txtTTL="+document.getElementById('txtTTL').value+"&txtEMail="+document.getElementById('txtEMail').value+"&txtComment="+document.getElementById('txtComment').value;
}
</script>

<?php
require_once 'footer.inc.php';
