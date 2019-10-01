<?php
/*
This script created by : Ahmet Berk BAŞARAN
Website : https://www.ahmetbasaran.com.tr
E-Mail : iletisim@ahmetbasaran.com.tr
Script Name : Teamspeak Domain Name Server Creator - With Cloudflare API-V4
*/


function temiz ($text) {
    $text = strip_tags($text);
    $text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)',$text );
    $text = preg_replace( '/<!--.+?-->/', '', $text );
    $text = preg_replace( '/{.+?}/', '', $text );
    $text = preg_replace( '/&nbsp;/', ' ', $text );
    $text = preg_replace( '/&amp;/', ' ', $text );
    $text = preg_replace( '/&quot;/', ' ', $text );
    $text = htmlspecialchars($text);
    $text = addslashes($text);
	$text = trim($text); 
    return $text;
}

function g($par){
	$par = temiz(@$_GET[$par]);
	return $par;
}

function p($par){
	$par = htmlspecialchars(trim(@$_POST[$par]));
	return $par;
}

function s($par){
	$session = $_SESSION[$par];
	return $session;
}