<?php

$data = [
    "fields" => array(
        "NAME" => "Подписчик {$_POST["EMAIL"]}",					
        "EMAIL" => array(	
            "n0" => array(
                "VALUE" =>  $_POST["EMAIL"],	
                "VALUE_TYPE" => "WORK",			
        ),
    ),
),
    'params' => array("REGISTER_SONET_EVENT" => "Y")	// Y = произвести регистрацию события добавления лида в живой ленте. Дополнительно будет отправлено уведомление ответственному за лид.	
];
$deal = file_get_contents("https://b24-gw5wc4.bitrix24.by/rest/1/dcbwvkwamzbcihp3/crm.contact.add.json?" . http_build_query($data));

?>
