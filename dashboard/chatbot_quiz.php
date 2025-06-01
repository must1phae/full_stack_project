<?php
// Sécurité
if (!isset($_GET['module']) || empty($_GET['module'])) {
    echo "Nom du module manquant.";
    exit;
}

$moduleName = htmlspecialchars($_GET['module']);
$apiKey = 'ta_clé_api_openai'; // Remplace par ta vraie clé API

// Préparer la requête
$data = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'system', 'content' => "Tu es un assistant qui génère des quiz pour les étudiants."],
        ['role' => 'user', 'content' => "Génère 5 questions de quiz avec réponses (QCM si possible) sur le module \"$moduleName\"."]
    ],
    'temperature' => 0.7,
];

// Initialiser cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Exécuter
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Erreur cURL : ' . curl_error($ch);
    exit;
}
curl_close($ch);

// Traiter la réponse
$responseData = json_decode($response, true);
$quiz = $responseData['choices'][0]['message']['content'] ?? "Erreur lors de la génération du quiz.";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz IA - <?= $moduleName ?></title>
    <link rel="stylesheet" href="../crud/style.css">
    <style>
        pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 10px;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <h1>Quiz généré par IA pour le module : <?= $moduleName ?></h1>
    <a class="retour" href="javascript:history.back()">← Retour</a>
    <pre><?= htmlspecialchars($quiz) ?></pre>
</body>
</html>
