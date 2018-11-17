<?php
require('../../config.php');
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://".$daemonip.":".$daemonport."/json_rpc");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"method\":\"getlastblockheader\",\"params\":{}}");
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$json = json_decode($result, true);
$diff = $json['result']['block_header']['difficulty'];
$hashrate = round($diff / $blockint);
print_r($hashrate);
