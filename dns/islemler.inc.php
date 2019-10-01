<?php
/* Bütün Hataları Görmezden Gel */
error_reporting(0);

/* Ahmet Berk BAŞARAN - PHP FONKSİYONLAR */ 
require_once 'fonksiyon.inc.php';

/* Cloudflare.com | APİv4 | Api Ayarları */
require_once 'ayarlar.inc.php';

$dnsadgeldi = strtolower(p('dnsadgeldi'));

/* ***** Girilen adı varmı kontrol et . BAŞLADI ***** */
$datamiz = file("karaliste.abb");
foreach($datamiz AS $ahmetbasaran)
   {
   $zerdi = explode("|", $ahmetbasaran);
	if($zerdi[1] == $dnsadgeldi)
	{
	echo"<meta http-equiv='refresh' content='1;url=index.php?p=zatenmevcut' />";
	exit;
	}
}
/* ***** Girilen adı varmı kontrol et . BİTTİ ***** */

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty(g('islem')) == 'dnsolusturabb'){

	$dnsadgeldi = p('dnsadgeldi');
	$dnsipgeldi = p('dnsipgeldi');
	$dnsportgeldi = p('dnsportgeldi');
	
	if(empty($dnsadgeldi)){
		echo '<div class="alert alert-warning">Lütfen dns adınızı girmeyi unutmayınız.</div>';	
	}elseif(!preg_match("/^[a-zA-Z0-9]*$/",$dnsadgeldi)) {
		echo '<div class="alert alert-warning">Sadece latin harfler desteklenmektedir, lütfen özel veya türkçe karakter girmeyiniz.</div>';
	}elseif($dnsadgeldi == "ftp" || $dnsadgeldi == "www" || $dnsadgeldi == "A" || $dnsadgeldi == "a" || $dnsadgeldi == "w" || $dnsadgeldi == "W") {
		echo '<div class="alert alert-warning">Bu dns adı kullanılamaz, lütfen farklı bir dns adı deneyin.</div>';
	}elseif(empty($dnsipgeldi)){
		echo '<div class="alert alert-warning">Lütfen ip adresinizi girmeyi unutmayınız.</div>';
	}elseif(!preg_match("/^[0-9.]*$/",$dnsipgeldi)) {
		echo '<div class="alert alert-warning">IP adresi bölümüne sadece ip adresi girebilirsiniz, lütfen sayılardan oluşan ip adresinizi giriniz.</div>';
	}elseif(empty($dnsportgeldi)){
		echo '<div class="alert alert-warning">Lütfen port numaranızı girmeyi unutmayınız.</div>';
	}elseif(!preg_match("/^[0-9]*$/",$dnsportgeldi)) {
		echo '<div class="alert alert-warning">Port bölümüne sadece port girebilirsiniz, lütfen sayılardan oluşan port numaranızı giriniz.</div>';
	}else{
		
		$dnsadgeldi = strtolower(p('dnsadgeldi'));
		
		// A-record oluşturur DNS sistemi için.
		$ch = curl_init("https://api.cloudflare.com/client/v4/zones/".$zoneid."/dns_records");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'X-Auth-Email: '.$email.'',
		'X-Auth-Key: '.$apikey.'',
		'Cache-Control: no-cache',
	    // 'Content-Type: multipart/form-data; charset=utf-8',
	    'Content-Type:application/json',
		'purge_everything: true'
		
		));
	
		// -d curl parametresi.
		$data = array(
		
			'type' => 'A',
			'name' => ''.$dnsadgeldi.'',
			'content' => ''.$dnsipgeldi.'',
			'zone_name' => ''.$domain.'',
			'zone_id' => ''.$zoneid.'',
			'proxiable' => true,
			'proxied' => true,
			'ttl' => '120'
		);
		
		$data_string = json_encode($data);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);	
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_string));

		$sonuc = curl_exec($ch);
		
		/*
		echo '<br> <h2> Sonuc 1 </h2> <br>';
		print_r($data_string); echo '<br';
		print_r($sonuc);
		*/
		
		curl_close($ch);

		// A Kaydı Oluşturulma İşlemi Sonrası SRV Kaydı Oluştur
		

		// SRV oluştur TS3DNS Aktif et.
		$ch2 = curl_init("https://api.cloudflare.com/client/v4/zones/".$zoneid."/dns_records");
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
		'X-Auth-Email: '.$email.'',
		'X-Auth-Key: '.$apikey.'',
		'Cache-Control: no-cache',
	    // 'Content-Type: multipart/form-data; charset=utf-8',
	    'Content-Type:application/json',
		'purge_everything: true'
		
		));
		
		// -d || Parametreler burada yer alıyor.
		
		$srvdata = array(
		'type' => 'SRV',
		'data' => array(
		"name"=>"".$dnsadgeldi."",
		"ttl"=>120,
		"service"=>"_ts3",
		"proto"=>"_udp",
		"weight"=>5,
		"port"=>intval($dnsportgeldi),
		"priority"=>0,
		"target"=>"".$dnsadgeldi.".".$domain.""
		));	
		
		$srv_data_string = json_encode($srvdata);

		curl_setopt($ch2, CURLOPT_POST, true);
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $srv_data_string);	
		//curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($data_string));

		$sonuc2 = curl_exec($ch2);

		/*
		echo '<br> <h2> Sonuc 2 </h2> <br>';
		print_r($sonuc2); echo '<br>';
		print_r($srv_data_string);
		*/
		
		curl_close($ch2);	

		if(!empty($sonuc) == true && !empty($sonuc2) == true){
			
			echo '<div class="alert alert-success">Tebrikler, dns oluşturma işleminiz başarılı, dns adresiniz : '.$dnsadgeldi.'.'.$domain.'</div>'; echo'<script type="text/javascript>">$("#dnsolusturForm")[0].reset();</script>';
			
			/* ***** Girilen adı karalisteye al. BAŞLADI ***** */
			$datangeldi = "|".$dnsadgeldi."|".$domain."|".intval($dnsportgeldi)."";
			//  Karaliste Alınır.
			$databankasi = "karaliste.abb";
			$datamiz = fopen($databankasi,"a");
			fwrite($datamiz, $datangeldi."\r\n");
			/* ***** Girilen adı karalisteye al. BİTTİ ***** */

		}else{
			echo '<div class="alert alert-error">Dns oluşturma işleminiz başarısız, lütfen girdiğiniz değerleri kontrol edin.</div>';
		}
		
		
		
		
	}		

}

?>