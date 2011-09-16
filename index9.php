<?php

$url = "http://theplaymob.com/weforest2/form1.php";
$data = "test data";

echo $url . "</br>";
echo $data . "</br>";

$params = array('http' => array( 
'method' => 'POST', 
'content' => $data 
)); 

echo $params['http']['method'] . " " . $params['http']['content'] . "</br>";

$ctx = stream_context_create($params); 

$fp = @fopen($url, 'rb', false, $ctx); 

if (!$fp) { 
echo "fail 1";
throw new Exception("Problem with $url, $php_errormsg"); 
} 

//echo $fp . "</br>";
echo "Creating response";

$response = @stream_get_contents($fp); 

echo $response;

if ($response === false) { 
echo "fail 2";
throw new Exception("Problem reading data from $url, $php_errormsg"); 
} 

echo $response; 

?>

<html>

</html>