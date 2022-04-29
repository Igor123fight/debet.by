<?
	$b24Url = "https://debetby.bitrix24.ru/";	// укажите URL своего Битрикс24
	$b24UserID = "1";						// ID пользователя, от имени которого будем добавлять лид
	$b24WebHook = "xv60sphb5cxdcuzz";		// код вебхука, который мы только что получили
	
	// формируем URL, на который будем отправлять запрос
	$queryURL = "$b24Url/rest/$b24UserID/$b24WebHook/crm.lead.add.json";	
	
	// формируем параметры для создания лида	
	$queryData = https_build_query(array(
		"fields" => array(
			"TITLE" => "Лид с нашего сайта",	// название лида
			"NAME" => "Меган Фокс",				// имя ;)
			'EMAIL' => Array(
				"n0" => Array(
					"VALUE" => str_replace(" ","",$_POST["email"]),
					"VALUE_TYPE" => "WORK",
				),
			), // Рабочая эл. почта
			//"PHONE" => array(	// телефон в Битрикс24 = массив, поэтому даже если передаем 1 номер, то передаем его в таком формате
		//		"n0" => array(
		//			"VALUE" =>  "+7 (123) 456-78-99",	// ненастоящий номер Меган Фокс
		//			"VALUE_TYPE" => "MOBILE",			// тип номера = мобильн
		"COMMENTS" => "Комментарий",
			),
		),
	)
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