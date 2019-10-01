<?php
require("config.php"); // DB stuff and variables

$count = 0;
foreach(array_reverse($roots) as $serv){
    $servip = $roots[$count][0];
    $servport = $roots[$count][1];
    try{
        $con = TeamSpeak3::factory("serverquery://serveradmin:{$querypw}@{$servip}:{$servport}/");
        $curservers = $con["virtualservers_running_total"];
    }catch(Exception $e){
        echo "Error (ID ".$e->getCode().") <b>".$e->getMessage()."</b> on IP: $servip:$servport<br/>";
    }
   
    $count++;
   
    if($curservers < $serv_limit){
        $curport = $servport;
        $curip = $servip;
        $servno = $count;
        break;
    }
}
?>

<?php
                                    $count = 0;
                                    foreach($roots as $serv){
                                        $servip = $roots[$count][0];
                                        $servport = $roots[$count][1];
                                        //Create connection
                                        $con = TeamSpeak3::factory("serverquery://serveradmin:{$querypw}@{$servip}:{$servport}/");
                                        // Get info
                                        $curservers = $con["virtualservers_running_total"];
                                        $curclients = $con["virtualservers_total_clients_online"];
                                        $curbytes = ($con["connection_bytes_received_total"] / 1024);
                                       
                                        if($curservers < 1000){
                                            $class = " class=\"success\"";
                                        }else{
                                            $class = " class=\"danger\"";
                                        }
                                        // Calculate totals
                                        $servers = ($con["virtualservers_running_total"] + $servers);
                                        $clients = ($con["virtualservers_total_clients_online"] + $clients);
                                        $band = ($con["connection_bytes_received_total"] + $con["connection_bytes_sent_total"] + $band);
                                       
                                        $count++; // Increment counter
                                       


                                    } ?>



<?php
// Set the JSON header
header("Content-type: text/json");

// The x value is the current JavaScript time, which is the Unix time multiplied by 1000.
$x = time() * 1000;
// The y value is a random number
$y = $clients;

// Create a PHP array and echo it as JSON
$ret = array($x, $y);
echo json_encode($ret);
?>