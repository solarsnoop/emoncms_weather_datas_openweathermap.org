<?php
###### EMONCMS API KEY #######################################################################
$apikey="PLEASE YOUR EMONCMS WRITE APIKEY"; ### EG: e28da6fa7f02bo172fd958b4184430b
$nodeid="Please your node id emoncms post"; ### EG: 2
$emoncmsurl="PLEASE URL FROM EMONCMS";      ### EG: emoncms or localhost or 127.0.0.1 or ...
$lat="please your location latitude";       ### EG: 51.1424
$lon="please your location longitude";      ### EG: 6.2777
$appid="please your openweathermap.org ID"; ### EG: 22222ff68af9e85w59ok3558p718q99
$cityname="please your cityname";           ### EG: Ulm,DE or 	Mönchengladbach,DE or ...
###  ##
##### Connect OPENWEATHERMAP FOR YOUR LOCATION BASED ON LONG AND LAT ########################
    $kelvin= -273.15;
    $urlforcast="http://api.openweathermap.org/data/2.5/weather?lat=".$lat."&lon=".$lon."&APPID=".$appid;
    ### GET JSON DATAS
  	$json=file_get_contents($urlforcast);
	  ### DECODE JSON DATAS
    $data=json_decode($json,true);
	  ### print out 
    echo $temp = $data['main']['temp']+$kelvin;
    echo " C<br>";
    echo $max_temp = $data['main']['temp_max']+$kelvin;
    echo " C<br>";
    echo $min_temp = $data['main']['temp_min']+$kelvin;
    echo " C<br>";
    echo $pressure = $data['main']['pressure'];
    echo "pa <br>";
    echo $humidity = $data['main']['humidity'];
    echo " %<br>";
	  ### define sunrise and sunset
    $sunrise = $data['sys']['sunrise'];
	  $sunrisetsp=$sunrise;
    $datumsr = date("d.m.Y",$sunrise);
    $uhrzeitsr = date("H:i",$sunrise);
    $uhrzeitsrh = date("H",$sunrise);
    $uhrzeitsrm = date("i",$sunrise);
  	### print out sunrise
    echo "sunrise: ".$datumsr," - ",$uhrzeitsr," Uhr<br>";
    $sunset = $data['sys']['sunset'];
    $sunsettsp=$sunset;
    $datumss = date("d.m.Y",$sunset);
    $uhrzeitss = date("H:i",$sunset);
    $uhrzeitssh = date("H",$sunset);
    $uhrzeitssm = date("i",$sunset);
	  ### print out sunset
    echo "sunset: ".$datumss," - ",$uhrzeitss," Uhr<br>";
    ### get cloud forecast
    $urlforcast="http://api.openweathermap.org/data/2.5/forecast?q=".$cityname."&APPID=".$appid;
    $json=file_get_contents($urlforcast);
    $data=json_decode($json,true);
    echo $wolken = $data['list'][0]['clouds']['all'];
    echo " %<br>";
    echo $wolkenm = $data['list'][1]['clouds']['all'];
    echo " %<br>";
    $temp=$temp*100;
    ##### Send to emoncms #############################################################################################
    $result = readfile("http://".$emoncmsurl."/input/post?json={temport:".$temp.",tempmaxort:".$max_temp.",tempminort:".$min_temp.",pressureort:".$pressure.",humidityort:".$humidity.",sunrisehort:".$uhrzeitsrh.",sunrisemort:".$uhrzeitsrm.",sunsethort:".$uhrzeitssh.",sunsemtort:".$uhrzeitssm.",sunset:".$sunsettsp.",sunrise:".$sunrisetsp.",cloudtd:".$wolken.",cloudtm:".$wolkenm."}&node=".$nodeid."&apikey=".$apikey);
?> 
