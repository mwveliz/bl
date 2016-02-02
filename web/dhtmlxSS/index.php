<?php
	require_once("./installer/installer.php");
	$problems = Array();

	$inst = new SpreadsheetInstaller();
	if (!$inst->checkPHPVersion("5")) {
		$problems[] = "Spreadsheet requires PHP 5.x";
	}

	if (isset($_POST['update'])) {
		$inst->update();
		$inst->removeInstallFiles();
		unlink(__FILE__);
		$inst->redirectTo("samples/01_simple_init.html");
		die();
	}
	
	if (isset($_POST['db_host'])) {
		$db_host = $_POST['db_host'];
		if (isset($_POST['db_port'])) {
			$db_port = $_POST['db_port'];
		} else {
			$problems[] = "Database port should be specified.";
		}
		if (isset($_POST['db_user'])) {
			$db_user = $_POST['db_user'];
		} else {
			$problems[] = "Database user should be specified.";
		}
		if (isset($_POST['db_pass'])) {
			$db_pass = $_POST['db_pass'];
		} else {
			$problems[] = "Database password should be specified.";
		}
		if (isset($_POST['db_name'])) {
			$db_name = $_POST['db_name'];
		} else {
			$problems[] = "Database name should be specified.";
		}
		$db_prefix = isset($_POST['db_prefix']) ? $_POST['db_prefix'] : '';
		$db_type = isset($_POST['db_type']) ? $_POST['db_type'] : 'MySQL';

		$conn = $inst->checkDBConnection($db_host, $db_port, $db_user, $db_pass, $db_name, $db_type);
		if ($conn === true) {
			if ((count($problems) == 0)) {
				$inst->copyFiles();
				$inst->createConfigFile("./codebase/php/config.php", $db_host, $db_port, $db_user, $db_pass, $db_name, $db_prefix, $db_type);
				$inst->loadDump($db_host, $db_port, $db_user, $db_pass, $db_name, $db_type, $db_prefix);
				$inst->removeInstallFiles();
				unlink(__FILE__);
				$inst->redirectTo("samples/01_simple_init.html");
			}
		} else {
			if (is_string($conn))
				$problems[] = $conn;
			else
				$problems[] = "Database connection is failed. Check database configuration.";
		}
	}


	if ((!isset($_POST['db_host']))||(count($problems) > 0)) {
		?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Spreadsheet installation</title>
	<link rel="stylesheet" type="text/css" href="installer/install.css" />
	<script>
		function doOnLoad() {

		}
		function openinstall() {
			document.getElementById('dbconn').className = 'dbconnection visible';
			return false;
		}
	</script>
</head>
<body onload="doOnLoad();">
	<div class="center_div">
		<div id="install_main">
			<div id="install_header">
				<div id="install_header_left"></div>
				<div id="install_header_right"></div>
			</div>
			<div id="install_content">
				<div id="content_step_1">
					<?php if ($inst->isUpdating()) { ?>
					<form action="" method="POST">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td class="first_td">&nbsp;</td>
								<td><div class="message">DHTMLX SpreadSheet updating</div></td>
							</tr>
							<tr>
								<td class="first_td">&nbsp;</td>
								<td>
									You have already had Spreadsheet installed.
									If you want to update the existing installation, click  button "Update".<br/><br/>
									<input class="button update" type="submit" name="update" value="&nbsp;"><br/><br/><br/>
									If you want to re-install it, use <a href="" onclick="return openinstall();">the following form</a>.
								</td>
							</tr>
						</table>
					</form>
					<?php } ?>
					<form action="" method="POST" class="dbconnection<?php echo ($inst->isUpdating() ? ' hidden' : ' visible');?>" id="dbconn">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td class="first_td">&nbsp;</td>
								<td><div class="message">Database configuration</div></td>
							</tr>
							<?php

								if (count($problems) > 0) {
									for ($i = 0; $i < count($problems); $i++) {
										?>
										<tr class="error_row">
										<td class="first_td"><div>Error:</div></td>
										<td><div class="error_msg"><div><?php echo $problems[$i]; ?><br></div></div></td>
										</tr>
										<?php
									}
								}

							?>
							<tr>
							<td class="first_td" valign="top">Database type:</td>
							<td>
								<?php $db_type = (isset($db_type) ? $db_type : 'MySQL') ?>
								<select class="input" name="db_type" value="">
									<option value="MySQL"<?php if ($db_type === 'MySQL') echo " selected"; ?>>MySQL</option>
									<option value="MySQLi"<?php if ($db_type === 'MySQLi') echo " selected"; ?>>MySQLi</option>
									<option value="MsSQL"<?php if ($db_type === 'MsSQL') echo " selected"; ?>>MSSQL</option>
									<option value="Oracle"<?php if ($db_type === 'Oracle') echo " selected"; ?>>Oracle</option>
									<option value="Postgre"<?php if ($db_type === 'Postgre') echo " selected"; ?>>Postgre</option>
								</select>
								<span class="hint">Database type to use.<br></span>
								</td>
							</tr>
							<tr>
								<td class="first_td" valign="top">Database host:</td>
								<td>
									<input class="input" id="db_host" name="db_host" value="<?php echo (isset($db_host) ? $db_host : 'localhost') ?>" type="text"><span style="padding: 0 4;">:</span>
									<input class="input" id="db_port" name="db_port" value="<?php echo (isset($db_port) ? $db_port : '3306') ?>" type="text">
									<span class="hint">If your database is located on a different server, change this</span>
								</td>
							</tr>
							<tr>
							<td class="first_td" valign="top">Database name:</td>
							<td>
								<input class="input" name="db_name" value="<?php echo (isset($db_name) ? $db_name : 'sampledb') ?>" type="text">
								<span class="hint">The name of the database your data is stored in.<br></span>
								</td>
							</tr>
							<tr>
								<td class="first_td" valign="top">Prefix:</td>
								<td><input class="input" name="db_prefix" value="<?php echo (isset($db_prefix) ? $db_prefix : '') ?>" type="text"></td>
							</tr>
							<tr>
								<td class="first_td" valign="top">User:</td>
								<td><input class="input" name="db_user" value="<?php echo (isset($db_user) ? $db_user : 'root') ?>" type="text"></td>
							</tr>
							<tr>
								<td class="first_td" valign="top">Password:</td>
								<td><input class="input" name="db_pass" value="<?php echo (isset($db_pass) ? $db_pass : '') ?>" type="password"></td>
							</tr>
							<tr class="button-row">
								<td class="first_td">&nbsp;</td>
								<td><input class="button install" type="submit" name="next" value="&nbsp;"></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
		<?php
	} else {

	}


?>