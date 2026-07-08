<?php
require_once 'includes/ai.php';
require_once 'includes/repositories/ChatRepository.php';
$response = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prompt = $_POST['prompt'];

    if (!$prompt) {
        die("PROMPT KOSONG");
    }

    $response = askAI($prompt);

    if (!$response) {
        $response = "AI RETURN EMPTY";
    }
}

function cleanAIOutput(string $text): string
{
    // hapus <br>
    $text = str_replace(["<br>", "<br/>", "<br />"], "\n", $text);

    // rapikan multiple newline
    $text = preg_replace("/\n{3,}/", "\n\n", $text);

    // trim spasi aneh
    $text = trim($text);

    return $text;
}
function formatAIText(string $text): string
{
    // HEADERS ### -> uppercase simple
    $text = preg_replace('/^###\s*(.+)$/m', '<b>$1</b>', $text);
    $text = preg_replace('/^##\s*(.+)$/m', '<b>$1</b>', $text);
    $text = preg_replace('/^#\s*(.+)$/m', '<b>$1</b>', $text);

    // bold **text**
    $text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $text);

    // bullet - -> •
    $text = preg_replace('/^\-\s+/m', '• ', $text);

    return nl2br($text);
}
function stripAIHtml($text)
{
    // hapus semua tag HTML
    $text = strip_tags($text);

    // rapikan newline
    $text = preg_replace("/\n{3,}/", "\n\n", $text);

    return trim($text);
}


?>

<div class="ai-terminal">

    <div class="ai-output">

        <div class="ai-header">

            <div class="ai-header-left">
                <div class="ai-title">AI TRADING TERMINAL</div>

                <div class="ai-subtitle">
                    Model : Geverich Ai V 0.5 &nbsp;&nbsp;|&nbsp;&nbsp;
                    Memory : Enabled
                </div>
            </div>

            <div class="ai-status" id="aiStatus">

                <span class="status-dot"></span>

                <span id="statusText">
                    ONLINE
                </span>

            </div>

        </div>

        <?php if ($response): ?>
            <div class="ai-response">
                <?= nl2br(htmlspecialchars($response)) ?>
            </div>
        <?php else: ?>
            <div class="ai-response" style="opacity:0.5">
                Type something to start...
            </div>
        <?php endif; ?>

    </div>

    <form method="POST" class="ai-input-bar">

        <textarea name="prompt" placeholder="Ask AI..." required></textarea>

        <button type="submit">SEND</button>

    </form>

</div>

<script>
    const aiForm = document.querySelector(".ai-input-bar");

    if (aiForm) {

        aiForm.addEventListener("submit", function() {

            const status = document.getElementById("aiStatus");
            const text = document.getElementById("statusText");


            if (status && text) {

                status.classList.add("thinking");

                text.innerHTML = "THINKING...";

            }

        });

    }
</script>