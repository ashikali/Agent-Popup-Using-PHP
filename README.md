## Agent-Popup-Using-PHP
   This is an Agent Pop Up Server/Client application to alert the agent with POPUP or URL notification when he/she receives the call.

## ami_proxy.php
   This is an agent pop-up server side script connected to asterisk using AMI interface and watches the extension status when the agent extension gets ringing it will send the notification to 
   client via a usual UDP Client socket.
   
## agent_popup_client.php
   This is an client pop-up script which is running on the Agent PC. At first this script will register IP with extenion on server using http web link register_popup.php. Now the 
   ami proxy script knows the IP address of the extension. This script created UDP Server and listening on it. when the AMI Sends the alert via UDP this script will raise the notification 
   to the agent.
   
## register_popup.php
   This is a http web link script for the registeration. The agent_popup_client.php script calls this script with extension. In fact the ip address will be automatically detected
   after the call by client secript using http get. For example http://<ami proxy IP>/register_popup.php?port=9090&channel=SIP/10001"
   
## amiproxy_service
   This is an init.d daemon script for ami_proxy.php
   
## tables.sql
   mysql script to crate table.
   
## paloSantoDB.class.php
   This is a simple database access library
   
## Tested Environment

   CentOS 7,Asterisk 16,php 5.6
   
With Cheers,
   
Ashik
   

   
  
 
   


