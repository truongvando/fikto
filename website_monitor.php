<?php

define("TOKEN", "6012916312:AAFT6v-uubxXfyVLbpnmON3l9luAd6FmG9M");
define("CHAT_ID", "Reporterrordie_bot");
define("URL", "https://fkzuxl.cfd/3Fi8i6eZ");
define("CHECK_INTERVAL", 1 * 60); // 1 minutes in seconds

function check_website($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch);
    $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $response_code == 200;
}

function send_telegram_message($message) {
    $bot_url = "https://api.telegram.org/bot" . TOKEN . "/sendMessage";
    $data = [
        "chat_id" => CHAT_ID,
        "text" => $message
    ];
    $ch = curl_init($bot_url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

while (true) {
    if (!check_website(URL)) {
        send_telegram_message("⚠️ Lỗi: Trang web " . URL . " không thể truy cập!");
    }
    sleep(CHECK_INTERVAL);
}

?>