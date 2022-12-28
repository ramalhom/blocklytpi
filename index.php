<?php

// Remplacez <votre-clé> par votre clé d'abonnement Azure
$apiKey = "<votre-clé>";

// Remplacez <votre-url> par l'URL de votre image
$imageUrl = "<votre-url>";

// Préparez la requête
$requestBody = array(
  "url" => $imageUrl
);

// Encodez la requête en JSON
$requestBody = json_encode($requestBody);

// Préparez les en-têtes de la requête
$headers = array(
  "Content-Type: application/json",
  "Ocp-Apim-Subscription-Key: $apiKey"
);

// Créez un contexte de flux pour la requête HTTP
$context = stream_context_create(array(
  "http" => array(
    "method" => "POST",
    "header" => implode("\r\n", $headers),
    "content" => $requestBody
  )
));

// Envoyez la requête et récupérez la réponse
$response = file_get_contents("https://<votre-région>.api.cognitive.microsoft.com/vision/v3.0/ocr", false, $context);

// Décodez la réponse en un objet PHP
$response = json_decode($response);

// Affichez le texte détecté dans l'image
foreach ($response->regions as $region) {
  foreach ($region->lines as $line) {
    foreach ($line->words as $word) {
      echo $word->text . " ";
    }
    echo "\n";
  }
  echo "\n";
}

?>