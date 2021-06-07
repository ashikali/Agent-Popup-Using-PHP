<?php
$palo_libs = "/var/www/html/libs" ;
set_include_path(get_include_path() . PATH_SEPARATOR . $palo_libs);


require_once "paloSantoDB.class.php";
$dsn = "mysql://asterisk:asterisk@localhost/amiproxy";


function getDB() {
    global $dsn;
    $pDB = new paloDB($dsn);
    return $pDB;

}
$_GET["ip"] = $_SERVER['REMOTE_ADDR'];

if(isset($_GET["ip"]) and $_GET["ip"] != ""
        and isset($_GET["port"]) and $_GET["port"] != ""
        and isset($_GET["channel"]) and $_GET["channel"] != ""
         ) {

        $db=getDB();
        $query = "DELETE FROM ami_proxy WHERE contact='{$_GET['ip']}'";
        $db->genQuery($query);
        $query = "DELETE FROM ami_proxy WHERE channel='{$_GET['channel']}'";
        $db->genQuery($query);
        $query = "INSERT INTO ami_proxy(contact,port,channel) VALUES('{$_GET[ "ip"]}','{$_GET[ "port"]}','{$_GET["channel"]}')";
        if($db->genQuery($query))
                echo($_GET["ip"]);

}
else {
echo "Please, fill chennel , port  and ip";

}
?>

