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
$hash = $json['result']['block_header']['hash'];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://".$daemonip.":".$daemonport."/json_rpc");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"jsonrpc\":\"2.0\",\"method\":\"f_block_json\",\"params\":{\"hash\":\"$hash\"}}");
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$blockData = json_decode($result, true);
$supplyRaw = $blockData['result']['block']['alreadyGeneratedCoins'];
$supply = number_format($supplyRaw / $coinunit, 2, ".", "");
print_r($supply);