#!/usr/local/bin/php -q
<?php
error_reporting(E_ALL);


class CallListener {


	function CallListener() {

/*
		$exec = exec("hostname"); //the "hostname" is a valid command in both windows and linux
		$hostname = trim($exec); //remove any spaces before and after
		$ip = gethostbyname($hostname); //resolves the hostname using local hosts resolver or DNS	 */

		$this->port = "8090";
		$this->listen = "SIP/8206";
		$this->err = "";
		$this->address = file_get_contents("http://10.10.5.68/register_popup.php?port={$this->port}&channel={$this->listen}");

		if (($this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) 
		    $this->err = "socket_create() failed: reason: " . socket_strerror(socket_last_error());
		
		if (socket_bind($this->sock, $this->address, $this->port) === false) 
		    $this->err = "socket_bind() failed: reason: " . socket_strerror(socket_last_error($this->sock)) . "\n";

		echo "Listening on {$this->address} port => {$this->port}  Channel => {$this->listen}";
		
		if (socket_listen($this->sock, 5) === false) {
		    $this->err =  "socket_listen() failed: reason: " . socket_strerror(socket_last_error($this->sock)) . "\n";
		}
	}

	function start() {


		do {
		    if (($msgsock = socket_accept($this->sock)) === false) {
		        $this->err = "socket_accept() failed: reason: " . socket_strerror(socket_last_error($this->sock)) . "\n";
		        break;
		    }
		    if (false === ($buf = socket_read($msgsock, 2048))) {
		        $this->err = "socket_read() failed: reason: " . socket_strerror(socket_last_error($this->msgsock)) . "\n";
		        break;
		    }
		    $talkback = "OK";
		    socket_write($msgsock, $talkback, strlen($talkback));
		    $data = unserialize($buf);
			system("start chrome \"http://www.google.com?search={$data[1]}\"");
		 	echo("start chrome \"http://www.google.com?search={$data[1]}\"");
		    socket_close($msgsock);
		} while (true);

		echo $this->err;
		socket_close($sock);
		
	}

}

#$listen = new CallListener();
#$listen->start();

while(true){
	
`start chrome www.google.com`;
 sleep(10);

}

?>
