<?php

class SpreadsheetInstaller {
	
	private $dump = './installer/spreadsheet.sql';

	public function checkPHPVersion($min_version) {
		if (is_string($min_version)) {
			$min_version = (double) $min_version;
		}
		$version = (double) phpversion();
		if ($version < $min_version) {
			return false;
		} else {
			return true;
		}
	}

	public function isUpdating() {
		if (file_exists('./codebase/php/config.php'))
			return true;
		else
			return false;
	}

	public function checkWritePermissions($path, $create = false) {
		if (file_exists($path)) {
			return is_writable($path);
		} else {
			if ($create == true) {
				return mkdir($path, 0777);
			} else {
				return false;
			}
		}
	}


	private function DBConnect($db_host, $db_port, $db_user, $db_pass, $db_name, $db_type) {
		$method = strtolower($db_type)."DBConnect";
		$driver_name = $db_type.'DBDataWrapper';
		$conn = null;
		if (method_exists($this, $method))
			$conn = $this->$method($db_host, $db_port, $db_user, $db_pass, $db_name);

		// creates dbwrapper
		if ($conn && !is_string($conn) && class_exists($driver_name))
			$conn = new $driver_name($conn, null);

		return $conn;
	}

	private function mysqlDBConnect($db_host, $db_port, $db_user, $db_pass, $db_name) {
		require_once("./installer/src/codebase/php/db_common.php");
		$db_server = ($db_port !== '') ? $db_host.":".$db_port : $db_host;
		if (!function_exists("mysql_connect")) return "PHP extension for MySQL is not available";
		@$res=mysql_connect($db_server, $db_user, $db_pass);
		if (!$res) return null;
		if (!mysql_select_db($db_name)) return null;
		return $res;
	}

	private function mysqliDBConnect($db_host, $db_port, $db_user, $db_pass, $db_name) {
		require_once("./installer/src/codebase/php/db_mysqli.php");
		if (!class_exists("mysqli")) "PHP extension for MySQLi is not available";
		@$res = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
		if (!$res) return null;
		if (mysqli_connect_errno()) return null;
		return $res;
	}

	private function mssqlDBConnect($db_host, $db_port, $db_user, $db_pass, $db_name) {
		require_once('./installer/src/codebase/php/db_mssql.php');
		$db_server = ($db_port !== '') ? $db_host.":".$db_port : $db_host;
		if (!function_exists("mssql_connect")) return "PHP extension for MSSQL is not available";
		@$res = mssql_connect($db_server, $db_user, $db_pass);
		if (!$res) return null;
		if (!mssql_select_db($db_name, $res)) return null;
		return $res;
	}

	private function postgreDBConnect($db_host, $db_port, $db_user, $db_pass, $db_name) {
		require_once("./installer/src/codebase/php/db_postgre.php");
		if (!function_exists("pg_connect")) return "PHP extension for PostgreSQL is not available";
		@$res = pg_connect("host=".$db_host." port=".$db_port." dbname=".$db_name." user=".$db_user." password=".$db_pass);
		if (!$res) return null;
		return $res;
	}

	private function oracleDBConnect($db_host, $db_port, $db_user, $db_pass, $db_name) {
		require_once('./installer/src/codebase/php/db_oracle.php');
		if (!function_exists("oci_connect")) return "PHP extension for Oracle is not available";
		$res = oci_connect($db_user, $db_pass, $db_name);
		if (!$res) return null;
		return $res;
	}

	public function checkDBConnection($db_host, $db_port, $db_user, $db_pass, $db_name, $db_type = 'MySQL') {
		$wrapper = $this->DBConnect($db_host, $db_port, $db_user, $db_pass, $db_name, $db_type);
		if (is_string($wrapper)) return $wrapper;
		return ($wrapper) ? true : false;
	}


	public function copyFiles() {
		$this->copy('./installer/src/codebase', './codebase');
		$this->copy('./installer/src/samples', './samples');
		$this->copy('./installer/src/skins', './skins');
	}


	/*! creates default database structure
	 */
	public function loadDump($db_host, $db_port, $db_user, $db_pass, $db_name, $db_type, $db_prefix) {
		$wrapper = $this->DBConnect($db_host, $db_port, $db_user, $db_pass, $db_name, $db_type);

		$dump = file_get_contents($this->dump);
		$dump = str_replace("#__", $db_prefix, $dump);
		$queries = $this->dumpToQueries($dump);

		for ($i = 0; $i < count($queries); $i++) {
			$query = $queries[$i];
			$result = $wrapper->query($query);
		}
	}


	private function copy($from, $to) {
		if (!file_exists($to)) mkdir($to, 0777);
		$dir = opendir($from);
		while ($file = readdir($dir)) {
			if ($file === '..' || $file === '.')  continue;
			if (is_dir($from.'/'.$file))
				$this->copy($from.'/'.$file, $to.'/'.$file);
			else
				copy($from.'/'.$file, $to.'/'.$file);
		}
 		closedir($dir);
	}


	/*! take dump content and convert it to single queries list
	 *	@param dump
	 *		dump text
	 *	@return
	 *		Array of queries
	 */
	private function dumpToQueries($dump) {
		$dump = preg_replace("/^\-\-.*$/im", "", $dump);
		$dump = preg_replace("/\/\*.*\*\//ims", "", $dump);
		$dump = preg_replace("/(\r?\n){1,}/", "$1", $dump);
		$dump = preg_split("/;\r?\n/", $dump);
		$queries = Array();
		for ($i = 0; $i < count($dump); $i++) {
			$q = trim($dump[$i]);
			if ($q != "")
				$queries[$i] = $q;
		}
		return $queries;
	}


	public function createConfigFile($filename, $db_host, $db_port, $db_user, $db_pass, $db_name, $db_prefix, $db_type) {
		if ($db_port !== '') {
			$db_server = $db_host.":".$db_port;
		} else {
			$db_server = $db_host;
		}
		$config = "<?php\n\n";
		$config .= "\$db_host = '{$db_host}';\n";
		$config .= "\$db_port = '{$db_port}';\n";
		$config .= "\$db_user = '{$db_user}';\n";
		$config .= "\$db_pass = '{$db_pass}';\n";
		$config .= "\$db_name = '{$db_name}';\n";
		$config .= "\$db_prefix = '{$db_prefix}';\n";
		$config .= "\$db_type = '{$db_type}';\n";
		switch (strtolower($db_type)) {
			case 'mssql':
				$config .= "require_once('db_mssql.php');\n";
				break;
			case 'mysqli':
				$config .= "require_once('db_mysqli.php');\n";
				break;
			case 'oracle':
				$config .= "require_once('db_oracle.php');\n";
				break;
			case 'postgre':
				$config .= "require_once('db_postgre.php');\n";
				break;
		}
		
		$config .= "?>";
		file_put_contents($filename, $config);
	}

	public function removeInstallFiles() {
		$this->removeDir("installer");
	}


	public function update() {
		$this->copy('./installer/src/codebase', './codebase');
		$this->copy('./installer/src/skins', './skins');

		// parse configuration
		$config = './codebase/php/config.php';
		if (file_exists($config)) require($config);
		if (!isset($db_host)) $db_host = "localhost";
		$db_host = explode(':', $db_host);
		$db_port = (isset($db_host[1])) ? $db_port = $db_host[1] : '3306';
		$db_host = $db_host[0];
		if (!isset($db_user)) $db_user = 'root';
		if (!isset($db_pass)) $db_user = 'pass';
		if (!isset($db_name)) $db_name = 'sampledb';
		if (!isset($db_prefix)) $db_prefix = '';
		if (!isset($db_type)) $db_type = 'MySQL';
		$this->createConfigFile($config, $db_host, $db_port, $db_user, $db_pass, $db_name, $db_prefix, $db_type);

		// run migrate script
		require('./codebase/php/migrate.php');
		$wrapper = $this->DBConnect($db_host, $db_port, $db_user, $db_pass, $db_name, $db_type);
		$mig = new dhxMigrate($wrapper, $db_prefix);
		$mig->update();
	}


	protected function removeDir($directory) {
		if (!file_exists($directory)) {
			return false;
		}
		$dir = opendir($directory);
		while(($file = readdir($dir))) {
			if (is_file ($directory."/".$file)) {
				unlink ($directory."/".$file);
			} elseif ((is_dir($directory."/".$file))&&($file != ".")&&($file != "..")) {
				$this->removeDir ($directory."/".$file);
			}
		}
		closedir ($dir);
		if (rmdir($directory)) {
			return true;
		} else {
			return false;
		}
	}

	public function redirectTo($url) {
		header('Location: '.$url);
	}

}

?>