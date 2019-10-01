<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Server AFK Checker</title>
</head>
<body>
    <?php
    /**
     * Created by PhpStorm.
     * User: XARON
     * Date: 20.11.2018
     * Time: 14:11
     */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    define('MAIN', true);
    date_default_timezone_set('Europe/London');
    ini_set('default_charset', 'UTF-8');
    setlocale(LC_ALL, 'UTF-8');
    require_once('ts3admin.class.php');

    $query = new ts3admin('127.0.0.1', 10101);
    if($query->getElement('success', $query->connect())) {
        $query->login('serveradmin', '1O2sjf4');
        $statistics = array();
        $cDate = strtotime(date('Y-m-d H:i:s'));
        foreach($query->serverList()['data'] as $k => $server) {
            $query->selectServer($server['virtualserver_port']);
            $query->setName(urlencode('Swallalala.'.rand(0, 1337)));
            $serverId = $server['virtualserver_id'];
            $serverName = $server['virtualserver_name'];
            $serverPort = $server['virtualserver_port'];
            array_push($statistics, array('serverId' => $serverId, 'serverName' => $serverName, 'serverPort' => $serverPort, 'total_afk' => 0, 'total_active' => 0, 'statistics' => array()));
            foreach($query->clientDbList()['data'] as $client) {
                if($client['client_nickname'] == 'ServerQuery Guest') continue;
                $checkTime = $client['client_lastconnected']+86400;
                if($checkTime > $cDate) {
                    $statistics[$k]['total_active']++;
                }
                if($checkTime < $cDate) {
                    $statistics[$k]['total_afk']++;
                }
                array_push($statistics[$k]['statistics'], array('nickname' => $client['client_nickname'], 'last_connection' => $client['client_lastconnected'], 'is_afk' => ($checkTime > $cDate) ? 'No' : 'Yes'));
            }
            if($statistics[$k]['total_active'] < 1) {
                $query->serverEdit(array('virtualserver_name' => 'Server is AFK'));
            }
        }
    }
    ?>
    <?php
    foreach($statistics as $statistic) {
    ?>
    <p class="font-weight-bold">Server: #<?=$statistic['serverId'].' - '.$statistic['serverName'].' - '.$statistic['serverPort'].' (Total AFK: '.$statistic['total_afk'].', Total Active: '.$statistic['total_active'].' [Last 24 hrs connection])'?></p><br/>
        <?php
            foreach($statistic['statistics'] as $user) {
        ?>
                <p class="font-weight-light">User: <?=$user['nickname'].' - Is Afk?: '.$user['is_afk']?></p>
        <?php } ?>
        <br/><br/><br/>
    <?php } ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>