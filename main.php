<?php

require_once 'header.inc.php';

//retrieve auth token and primary account number, then ask for account number to retrieve records for
$uname=trim(escapeshellarg($_REQUEST["txtUName"])," '");
$apikey=trim(escapeshellarg($_REQUEST["txtKey"])," '");

//Authenticate and grab token/master account number
$resp=shell_exec('curl -i -k -H "X-Auth-Key: '.$apikey.'" -H "X-Auth-User: '.$uname.'" https://auth.api.rackspacecloud.com/v1.0 2>&1');
$token=trim(shell_exec('echo -e "'.$resp.'" | grep "X-Auth-Token:" | awk "{print \$2}"'));
$acctnum=trim(shell_exec('echo "'.$resp.'" | grep "X-Server-Management-Url:" | rev | cut -d/ -f 1 | rev | head -c 6'));
?>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form class="form-horizontal" method="get" action="domains.php" name="frmAccnt" role="form">
      <legend>DNS Login</legend>
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
	<div class="col-sm-offset-2 col-sm-10">
	  <button type="submit" class="btn btn-default">Continue</button>
	</div>
      </div>
    </form>
  </div>
</div>

<?php

require_once 'footer.inc.php';

