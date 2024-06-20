<?php
$ipv4raw = file_get_contents("https://www.cloudflare.com/ips-v4/");
if ($ipv4raw === false) {
	die('failure getting ipv4 list');
}
$ipv4raw = trim($ipv4raw);
$ipv4 = array_map(function($l) {return trim($l);}, explode($ipv4raw, "\n"));

$ipv6raw = file_get_contents("https://www.cloudflare.com/ips-v6/");
if ($ipv6raw === false) {
	die('failure getting ipv6 list');
}
$ipv6raw = trim($ipv6raw);
$ipv6 = array_map(function($l) {return trim($l);}, explode($ipv6raw, "\n"));

$f = fopen('./.htaccess-cf', 'w');
if ($f === false) {
	die('failure opening file');
}

fwrite($f, "deny from all\n");

$ips = array_merge($ipv4, $ipv6);

foreach ($ips as $ip) {
	fwrite($f, "allow from {$ip}\n");
}

fclose($f);
