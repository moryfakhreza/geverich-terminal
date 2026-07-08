<?php

require_once __DIR__ . "/PromptBuilder.php";
require_once __DIR__ . "/MemoryManager.php";

class AIService
{
  private string $apiKey;

  public function __construct() {
    // Untuk sementara isi langsung.
    // Nanti kita pindahkan ke config.php.
    $this->apiKey = getenv(GROQ_API_KEY);
  }

  public function chat(int $userId, string $prompt): string
  {
    if (empty($this->apiKey)) {
      return "ERROR: API Key belum diatur.";
    }

    // Simpan pesan user
    MemoryManager::save($userId, "user", $prompt);

    // Susun seluruh prompt
    $messages = PromptBuilder::build($userId, $prompt);
  

    $payload = [
      "model" => "meta-llama/llama-4-scout-17b-16e-instruct",
      "messages" => $messages,
      "temperature" => 0.7,
      "max_tokens" => 2048
    ];
    $ch = curl_init("https://api.groq.com/openai/v1/chat/completions");

    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $this->apiKey,
        "Content-Type: application/json"
      ],
      CURLOPT_POSTFIELDS => json_encode($payload),
      CURLOPT_TIMEOUT => 60,
      CURLOPT_CONNECTTIMEOUT => 10,
      CURLOPT_SSL_VERIFYPEER => false
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
      return "AI ERROR: " . curl_error($ch);
    }

    if (curl_errno($ch)) {
      return "CURL ERROR: " . curl_error($ch);
    }

    $result = json_decode($response, true);

    if (!$result) {
      return "Invalid JSON Response";
    }

    if (isset($result["error"])) {
      return "API ERROR: " . $result["error"]["message"];
    }

    if (!isset($result["choices"][0]["message"]["content"])) {
      return "AI response empty.";
    }

    if (!$response) {
      return "ERROR: Empty response from API";
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode !== 200) {
      return "HTTP ERROR: " . $httpCode . "\n" . $response;
    }


    $replyRaw = $result["choices"][0]["message"]["content"];
    $replyRaw = preg_replace('/<think>.*?<\/think>/s', '', $replyRaw);

    $reply = trim($replyRaw);
    MemoryManager::save($userId, "assistant", $reply);

    return $reply;
  }
}