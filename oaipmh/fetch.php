<?php

echo "Hello";
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://palib1.ucas.edu.ps/api/psearch/fetch/29042',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYzIzMGU5ZjUzYmJkM2EwOWNlOGFlNmIwZDFjMGMyNTkzNmYxNzI5ZWNkNTQ4ZDUwZTdjNGEwOTdhMjA0NGVlYmQ0YzViOThhYzEyNjdiNDMiLCJpYXQiOjE2Mzk0NzUwMDEuMTc5NDc3LCJuYmYiOjE2Mzk0NzUwMDEuMTc5NDgyLCJleHAiOjE2NzEwMTEwMDEuMDkyNjkyLCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.ikNErq7tjGafy-T7lTtbyc5E3bIfyX6nT6Yq4Dp9Gru2_jzUPmOVQJ7X55jspsYRGmb0kVhxr7INoMCovHz8b2Yq5fTLJyamBMdW8cSEGS1WexhJEPzHrmqeQYa1UasI2ea0d80lay1VpV0Zfgvn-Z3taWMUSF91wODnNxr4TZwdM80ADNNdoe6_j8XGAUhxLPiwVxxH90EXmnKe7eimzr85tgdLuAyKrBEEFLZRCtiZNMsuZ_AYol29P8JgYvxyVRcppEUagmPtMVQmzPww5swBNEB5trQidVt1NBsHpYd7-y-h-GZHJJOtdaIkkh_tXuXFXqiv-xmNu-9cpC5dwlQp-Zgz837-D1THQOCvfIT_xUCBDbVa9gdeUi9-vMlQZWFZphhk4z0BYdC3YP6YdHAdc_FDJrSRZDXKbvVzrOzC2iZVNSkfQmDAzdEo0xsnlGqQg9Ah7xUr123ddU8o4QehNNItUU1JGsP2u4cwEGNU1cJISixazCcHbxu5hNmjdUpBu1CS1Jb4CQa5uwE9YPiKdilG71Ym_iSN9M17k3JgzOz7g7_cmroLLC0w_ngGAMmQunpzEWqL17ZEZyIDSAOdPdHUKOvgr6lTet1F8Y1sI2_Lf-Mx7_XFk8BzHaJAo2c_aLChQ5a80A4z7xfWDnyIxdfY_fwBTBZMix8QEN8'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?>