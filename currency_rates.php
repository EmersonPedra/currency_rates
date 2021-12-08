<?php


$ch = curl_init();
$timeout = 0;
curl_setopt($ch, CURLOPT_URL, 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml?5105e8233f9433cf70ac379d6ccc5775');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$conteudo = curl_exec($ch);
$xml = simplexml_load_string($conteudo);
$date = $xml->Cube->Cube["time"][0];
foreach($xml->Cube->Cube->Cube as $cube){
    if ($cube["currency"][0] == "USD"){
        $usd = floatval($cube["rate"]);
    }
   
  
}
$csv = fopen('usd_currency_rates_'.$date.'.csv', 'w');
fputcsv($csv, ['EU',  1/ $usd ]);
foreach($xml->Cube->Cube->Cube as $cube){
    fputcsv($csv,[$cube["currency"][0],(floatval($cube["rate"])/$usd)]);
}
fclose($csv);

curl_close($ch);

?>






