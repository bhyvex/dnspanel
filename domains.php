<?php

require_once 'header.inc.php';

//List domains
//Tasks - records, delete, new
$token=trim(escapeshellarg($_REQUEST["txtToken"])," '");
$acctnum=trim(escapeshellarg($_REQUEST["txtAcct"])," '");

//get domain list
$resp=shell_exec('curl -s -k -H "X-Auth-Token: '.$token.'" https://dns.api.rackspacecloud.com/v1.0/'.$acctnum.'/domains 2>&1');

$arrResp=json_decode(trim($resp),true);

?>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <table border="1" class="table table-striped table-condensed table-hover table-responsive">
    <tr><th>Domain</th><th>Last Modified</th><th>Delete</th></tr>
<?php
$arrDomains=$arrResp["domains"];
foreach ($arrDomains as $arrDomain) {
  echo "<tr><td><a href='records.php?txtAcct=".$acctnum."&txtToken=".$token."&txtDomain=".$arrDomain["id"]."&btnSubmit=Submit'>".$arrDomain["name"]."</a><td>".$arrDomain["updated"]."</td><td><a href='domaindelete.php?txtAcct=".$acctnum."&txtToken=".$token."&txtDomain=".$arrDomain["id"]."&btnSubmit=Submit''><span class=\"glyphicon glyphicon-trash\"></a></td></tr>";
}
?>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form class="form-horizontal" method="get" action="adddomain.php" name="frmAddDomain" role="form">
    <legend>Add Domain</legend>
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
	<label for="txtName" class="col-sm-2 control-label">Domain Name</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" id="txtName" name="txtName" placeholder="mydomain.com">
	</div>
    </div>
    
    <div class="form-group">
	<label for="txtTTL" class="col-sm-2 control-label">TTL</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" id="txtTTL" name="txtTTL" placeholder="86400">
	</div>
    </div>

    <div class="form-group">
	<label for="txtEMail" class="col-sm-2 control-label">Email Address</label>
	<div class="col-sm-10">
    <input type="email" class="form-control" id="txtEMail" name="txtEMail" placeholder="postmaster@mydomain.com">
	</div>
    </div>

    <div class="form-group">
	<label for="txtComment" class="col-sm-2 control-label">Auth Token</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" id="txtComment" name="txtComment" placeholder="A comment goes here but is not necessary">
	</div>
    </div>

    <div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
    <button type="reset" class="btn btn-danger">Clear</button>
	</div>
    </div>

    <div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-default">Add</button>
	</div>
    </div>
    </form>
  </div>
</div>
<?php

require_once 'footer.inc.php';