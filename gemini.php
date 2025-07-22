<?php
// مفتاح API - ⚠️ لا تنشره علنًا في الإنتاج
$api_key = "AIzaSyDxhQ0wyQV4keqR6OwlNO4EfV7_hhT80C0";

// الحصول على السؤال من الرابط
if (isset($_GET['text']) && !empty($_GET['text'])) {
    $question = strip_tags($_GET['text']);

    $postData = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $question]
                ]
            ]
        ]
    ];

    // الاتصال بـ Gemini API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-fash:generateContent?key=$api_key");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $result = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($result, true);
    if (isset($data["candidates"][0]["content"]["parts"][0]["text"])) {
        header('Content-Type: text/plain; charset=utf-8');
        echo $data["candidates"][0]["content"]["parts"][0]["text"];
    } else {
        echo "❌ حدث خطأ في الاتصال بالذكاء الاصطناعي.";
    }
} else {
    echo "⚠️ يرجى إضافة النص في الرابط، مثال:\n";
    echo "?text=ما+هو+الذكاء+الاصطناعي";
}