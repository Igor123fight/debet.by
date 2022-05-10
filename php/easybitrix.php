<?php

		$data = [
        "fields" => array(
			"TITLE" => "Лид с нашего сайта",	
			"NAME" => $_POST["NAME"],				
			"PHONE" => array(	
				"n0" => array(
					"VALUE" =>  $_POST["PHONE"],	
					"VALUE_TYPE" => "MOBILE",			
		"COMMENTS" => $_POST["COMMENTS"],
			),
		),
	),
		'params' => array("REGISTER_SONET_EVENT" => "Y")	// Y = произвести регистрацию события добавления лида в живой ленте. Дополнительно будет отправлено уведомление ответственному за лид.	
	];
    file_get_contents("https://b24-gw5wc4.bitrix24.by/rest/1/dcbwvkwamzbcihp3/crm.lead.add.json?" . http_build_query($data) );

	 //Отправляем в телеграм сообщения

	$token = "1876949943:AAHXMgBkoMckNyn6A_sLaG-h-uoaCSh0g8A";
	$PHONETEXT = (string)$_POST["PHONE"];
   	$textform = "Имя клиента {$_POST["NAME"]}, номер телефона {$PHONETEXT}, сообщение {$_POST["COMMENTS"]}"; 
	
	$data = [
		'text' => $textform,
        'chat_id' => '-1001409264569'
    ];
    
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );
?>	
