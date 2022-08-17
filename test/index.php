<?php
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "http://107.20.199.106/restapi/sms/1/text/",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => "{\n \"from\": \"Hola\",\n \"to\":[\"573166999882\", \"573112127944\", \"573164901515\", \"573007121902\"],\n \"text\": \"TEST SMS.\",\n \"language\": \"es\"\n}",
    
CURLOPT_HTTPHEADER => array(
 "accept: application/json",
 "authorization: Basic Q29sbGVjdHBheTpDMDNjN3A0MQ==",
 "content-type: application/json"
),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
echo "cURL Error #:" . $err;
} else {
echo $response;
}
