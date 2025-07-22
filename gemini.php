<?php
// مفتاح API الخاص بك - ⚠️ لا تشارك هذا مع الآخرين!
$api_key = "AIzaSyDxhQ0wyQV4keqR6OwlNO4EfV7_hhT80C0";
$question = "";
$response_text = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["question"])) {
    $question = strip_tags($_POST["question"]);

    $postData = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $question]
                ]
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=$api_key");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $result = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($result, true);
    if (isset($data["candidates"][0]["content"]["parts"][0]["text"])) {
        $response_text = $data["candidates"][0]["content"]["parts"][0]["text"];
    } else {
        $response_text = "حدث خطأ أثناء الاتصال بـ Gemini API.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ذكاء اصطناعي بـ PHP</title>
</head>
<body style="text-align:center; padding: 30px; font-family: Arial;">
    <h2>اكتب سؤالك للذكاء الاصطناعي</h2>
    <form method="POST">
        <input type="text" name="question" placeholder="مثلاً: ما هو الذكاء الاصطناعي؟" style="width:300px;" required>
        <button type="submit">أرسل</button>
    </form>

    <?php if (!empty($response_text)): ?>
        <div style="margin-top: 30px; border: 1px solid #ccc; padding: 20px;">
            <strong>الرد:</strong><br>
            <?= nl2br(htmlspecialchars($response_text)) ?>
        </div>
    <?php endif; ?>
</body>
</html>