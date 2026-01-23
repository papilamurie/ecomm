<?php
$ch = curl_init("https://YCYYQL851T.algolia.net/1/indexes");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-Algolia-API-Key: 8100b9ff243c9da3b38ea006d1836eb4",
    "X-Algolia-Application-Id: YCYYQL851T"
]);
$result = curl_exec($ch);
if(curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo $result;
}
curl_close($ch);
