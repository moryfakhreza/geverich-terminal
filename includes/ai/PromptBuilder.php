<?php

require_once __DIR__ . "/SystemPrompt.php";
require_once __DIR__ . "/ContextBuilder.php";
require_once __DIR__ . "/TradeContextBuilder.php";
require_once __DIR__ . "/MemoryManager.php";

class PromptBuilder
{
  public static function build(int $userId, string $prompt): array
  {
    $messages = [];

    // System Prompt + User Context
  $messages[] = [
    "role" => "system",
    "content" =>
        SystemPrompt::get()
        . "\n\n"
        . ContextBuilder::build($userId)
        . "\n\n"
        . TradeContextBuilder::build($userId)
];

    // Chat History
    foreach (array_reverse(MemoryManager::history($userId, 5)) as $chat) {

      $messages[] = [
        "role" => $chat["role"],
        "content" => $chat["message"]
      ];

    }

    // User Prompt
    $messages[] = [
      "role" => "user",
      "content" => $prompt
    ];

    return $messages;
  }
}