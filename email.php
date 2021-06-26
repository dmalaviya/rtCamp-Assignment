<?php
require './emailClass.php';
//Initialize cURL.
$ch = curl_init();

//Set the URL that you want to GET by using the CURLOPT_URL option.
curl_setopt($ch, CURLOPT_URL, 'https://c.xkcd.com/random/comic/');
//curl_setopt($ch, CURLOPT_URL, 'https://xkcd.com/448/');

//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

//Execute the request.
$data = curl_exec($ch);

//Close the cURL handle.
curl_close($ch);

//Print the data out onto the page.
//echo gettype($data);
//substr($data,26:30)
preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $data, $matches);

$xkcd_url = $matches[0] . "info.0.json";
echo $xkcd_url. "</br>";
$json = file_get_contents($xkcd_url);
$obj = json_decode($json);

echo gettype($obj);

foreach($obj as $key => $val) {
    echo "KEY IS: $key<br/>";
    echo "Value IS: $val<br/>";
}
$emailObj = new emailClass();
$emailObj ->sendEmail($obj);

function delete_all_between($beginning, $end, $string) {
  $beginningPos = strpos($string, $beginning);
  $endPos = strpos($string, $end);
  if ($beginningPos === false || $endPos === false) {
    return $string;
  }

  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

  return delete_all_between($beginning, $end, str_replace($textToDelete, '', $string)); // recursion to ensure all occurrences are replaced
}
?>