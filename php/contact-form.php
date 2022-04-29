<?php

// if the url field is empty
if(isset($_POST['url']) && $_POST['url'] == ''){

	// put your email address here
	$youremail = 'i.borshevski@yandex.ru';  

	// prepare message 
	$body = "You have got a new message from the contact form on your website - Xaasvik :
	
	Name:  $_POST[name]
	Email:  $_POST[email]
	Message:  $_POST[message]";

	if( $_POST['email'] && !preg_match( "/[\r\n]/", $_POST['email']) ) {
	  $headers = "From: $_POST[email]";
	} else {
	  $headers = "From: $youremail";
	}

	mail($youremail, 'Message from Xaasvik', $body, $headers );

} ?>

<!DOCTYPE HTML>
<html>
<head>
<title>Thanks!</title>
</head>
<body>
<p> Thank you! We will get back to you soon.</p>
</body>
</html>

<?
	$b24Url = "https://debetby.bitrix24.ru/";	// укажите URL своего Битрикс24
	$b24UserID = "1";						// ID пользователя, от имени которого будем добавлять лид
	$b24WebHook = "xv60sphb5cxdcuzz";		// код вебхука, который мы только что получили
	
	// формируем URL, на который будем отправлять запрос
	$queryURL = "$b24Url/rest/$b24UserID/$b24WebHook/crm.deal.add.json";	
	
	// формируем параметры для создания лида	
	$queryData = http_build_query(array(
		"fields" => array(
			"TITLE" => "Лид с нашего сайта",	// название лида
			"NAME" => "Меган Фокс",				// имя ;)
			"PHONE" => array(	// телефон в Битрикс24 = массив, поэтому даже если передаем 1 номер, то передаем его в таком формате
				"n0" => array(
					"VALUE" =>  "+7 (123) 456-78-99",	// ненастоящий номер Меган Фокс
					"VALUE_TYPE" => "MOBILE",			// тип номера = мобильный
				),
			),
		),
		'params' => array("REGISTER_SONET_EVENT" => "Y")	// Y = произвести регистрацию события добавления лида в живой ленте. Дополнительно будет отправлено уведомление ответственному за лид.	
	));

	// отправляем запрос в Б24 и обрабатываем ответ
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $queryURL,
		CURLOPT_POSTFIELDS => $queryData,
	));
	$result = curl_exec($curl);
	curl_close($curl);
	$result = json_decode($result,1); 
 
	// если произошла какая-то ошибка - выведем её
	if(array_key_exists('error', $result))
	{      
		die("Ошибка при сохранении лида: ".$result['error_description']);
	}
	
	echo "Лид добавлен, отличная работа :)";
?>