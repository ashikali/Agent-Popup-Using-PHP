
<?php
$agi_libs = "/var/lib/asterisk/agi-bin";
$palo_libs = "/var/www/html/libs" ;
set_include_path(get_include_path() . PATH_SEPARATOR . $agi_libs . PATH_SEPARATOR . $palo_libs);

require_once "phpagi.php";
require_once "paloSantoDB.class.php";
require_once "Log.php";

$dsn = "mysql://asterisk:asterisk@localhost/amiproxy";


class AmiProxy {


	function AmiProxy() {

		global $dsn;

                $path = "/var/lib/asterisk/agi-bin/amiproxy/log/proxy.log";
                $log_conf = array('append' => true,'timeFormat' => '%X %x','mode' => "0644") ;
                $this->log = Log::singleton("file", $path,"Log",$log_conf);
		$this->max_fail_count = 5;
		$this->db = new paloDB($dsn);
		$manager = Array( "username" => "agent_popup","secret" => "agent_popup" , "server" => "localhost" );
		$this->ami = new AGI_AsteriskManager(NULL,$manager);	
		if(!$this->ami->connect()) {
			$this->log->log("Invalid login..");
			return false;
		}		

	}

	function inform(&$contact,&$data) {

		$ip   = $contact["contact"];
		$port = $contact[ "port" ];
		$count =(int)$contact[ "fail_count" ];
		
		if($count < $this->max_fail_count ){
		
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if ($socket === false) {
	    			$this->log->log("socket_create() failed: reason: " . socket_strerror(socket_last_error()));
				return false;
			}
			$result = @socket_connect($socket, $ip, $port);
			if ($result === false) {
				$this->log->log("Unable to connect {$ip} {$port}...{$count}");
				$this->log->log( "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)));
				$query = "UPDATE ami_proxy SET fail_count=fail_count + 1
					  WHERE contact='${ip}'";
				$this->db->genQuery( $query );
			}else{

				$in = serialize($data);
				socket_write($socket, $in, strlen($in));
				$this->log->log("Writing data on {$ip} {$port}");

				$response = socket_read($socket, 2048);
				$this->log->log("Response From {$ip} {$port} {$response}");

			}
		      socket_close( $socket );

		}else{

			//if max try reached clear from table
			$query = "DELETE FROM ami_proxy WHERE contact='{$ip}'";
			$this->db->genQuery( $query );


		}

	}

}
$proxy = new AmiProxy();

function agent_called($ecode,$data,$server,$port) {

	global $proxy;	
	$data_to_send = Array( $data[ "Uniqueid" ],$data["CallerIDNum"] );
	$channel = $data["AgentCalled"];
	$query = "SELECT * FROM ami_proxy WHERE channel = '{$channel}'";
        $contacts =  $proxy->db->fetchTable($query,true);
	foreach( $contacts as $contact )
		$proxy->inform($contact,$data_to_send);	
	

}

$proxy->ami->add_event_handler("AgentCalled","agent_called");	
$proxy->ami->wait_response();
	


/*
amiproxy
ami_proxy
 `contact` varchar(128) default NULL,
  `channel` varchar(128) default NULL,
  `port` varchar(128) default '10000',
   fail_count
  `updated_on
*/


?>
