<?php
$access_token = "470d69cebea7d368-c0fc6ecb1b6c4720-f2e55cd91322af40";

$request = file_get_contents("php://input");
$input = json_decode($request, true);

if ($input['event'] == 'webhook'){
    $webhook_response['status'] = 0;
    $webhook_response['status_message'] = "Ok!";
    $webhook_response['event_types'] = "deliver";
    echo json_encode($webhook_response);
}
elseif ($input['event'] == 'message'){
    $text_received = $input['message']['text'];
    $sender_id = $input['sender']['id'];
    $sender_name = $input['sender']['name'];

    if ($text_received == 'Barev' || $text_received == 'Privet' || $text_received == 'Barev Dzez'){
        $message_to_reply = "Barev Dzez" .$sender_name. ". Inchov karogh em ognel?";
    }elseif ($text_received == 'Vonc es?' || $text_received == 'Inchpes es?' || $text_received == 'Vonceq?'){
        $message_to_reply = "Shnorhakalutyun" .$sender_name. ". Shat lav, duq inchpes eq?";
    }elseif ($text_received == 'Ov es?' || $text_received == 'Anund kases?' || $text_received == 'Inch e dzer anuny?'){
        $message_to_reply = "Hargeli" .$sender_name. ". Es information bot em, im anunne  ArmViber ";
    }
    else{
        $message_to_reply = "Barev Dzez, es information bot em. Khndrum em indz tveq harcer";
    }

    $data['auth_token'] = $access_token;
    $data['receiver'] = $sender_id;
    $data['type'] = "text";
    $data['text'] = $message_to_reply;
    sendMessage($data);
}

function sendMessage($data){
    $url = "https://chatapi.viber.com/armviber/send_message";
    $jsonData = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $result = curl_exec($ch);
    return $result;
}
