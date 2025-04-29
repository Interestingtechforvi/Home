<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KTM Assistant</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body { font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; background: #eef2f5; }
    #chat { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.2); }
    .message { margin-bottom: 20px; }
    .user { text-align: right; }
    .assistant { text-align: left; background: #f1f8ff; padding: 10px; border-radius: 10px; position: relative; outline: none; }
    .assistant-line { margin-bottom: 8px; }
    #prompt { width: 70%; padding: 12px; font-size: 16px; border-radius: 6px; border: 1px solid #ccc; }
    button { padding: 12px; margin: 5px; border-radius: 6px; border: none; background: #007bff; color: white; font-size: 16px; cursor: pointer; }
    button:hover { background: #0056b3; }
    #loading { display: none; color: #dc3545; font-weight: bold; text-align: center; margin-top: 10px; }
    #actionMenu { display: none; position: fixed; background: white; border: 1px solid #ccc; border-radius: 8px; padding: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 9999; }
    #actionMenu button { width: 100%; margin: 5px 0; }
    #header { max-width: 800px; margin: auto; text-align: center; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.2); margin-bottom: 20px; position: relative; }
    #settingsBtn { position: absolute; right: 20px; top: 20px; background: #ffc107; color: black; padding: 8px 12px; border-radius: 6px; border: none; cursor: pointer; }
    #settingsBtn:hover { background: #e0a800; }
</style>
</head>
<body>

<div id="header">
    <h2>Welcome to KTM Assistant</h2>
    <button id="settingsBtn">Settings</button>
    <h3>Learn Programming Faster with KTM Assistant</h3>
    <p>Ask about coding tutorials, languages, frameworks, debugging, or anything tech related!</p>
</div>

<div id="chat" aria-live="polite" aria-atomic="false"></div>

<div style="text-align: center; margin-top: 15px;">
    <input type="text" id="prompt" placeholder="Type your message..." aria-label="Type your message">
    <button id="voiceInput" aria-label="Voice Input">🎤</button>
    <button id="send" aria-label="Send Message">Send</button>
</div>

<div id="loading" aria-live="assertive">Please wait, Assistant is typing...</div>

<div id="actionMenu" role="dialog" aria-modal="true">
    <button id="copyBtn">Copy</button>
    <button id="shareBtn">Share</button>
    <button id="regenerateBtn">Regenerate</button>
</div>

<script>
// Elements
const chat = document.getElementById('chat');
const promptInput = document.getElementById('prompt');
const sendBtn = document.getElementById('send');
const voiceInputBtn = document.getElementById('voiceInput');
const loading = document.getElementById('loading');
const settingsBtn = document.getElementById('settingsBtn');
const actionMenu = document.getElementById('actionMenu');
const copyBtn = document.getElementById('copyBtn');
const shareBtn = document.getElementById('shareBtn');
const regenerateBtn = document.getElementById('regenerateBtn');

let longPressTimer;
let selectedAssistantText = '';
let selectedPrompt = '';

// Focus cursor to prompt box on page load
window.onload = () => {
    promptInput.focus();
};

// Settings button
settingsBtn.onclick = () => {
    alert('Settings Coming Soon...');
};

// Send prompt
sendBtn.onclick = async () => {
    const prompt = promptInput.value.trim();
    if (!prompt) return;
    appendMessage('user', prompt);
    promptInput.value = '';
    loading.style.display = 'block';
    try {
        const res = await fetch('https://blindtools.in/gemini.php?prompt=' + encodeURIComponent(prompt));
        const data = await res.json();
        if (data && data.msg) {
            appendAssistantMessage(data.msg, prompt);
        } else {
            appendAssistantMessage('No valid response received.', prompt);
        }
    } catch (e) {
        appendAssistantMessage('Error fetching assistant reply.', prompt);
    }
    loading.style.display = 'none';
};

// Append user message
function appendMessage(sender, text) {
    const msg = document.createElement('div');
    msg.className = 'message ' + sender;
    msg.innerHTML = `<div>${text}</div>`;
    chat.appendChild(msg);
    chat.scrollTop = chat.scrollHeight;
}

// Append assistant message (screen reader friendly)
function appendAssistantMessage(text, originalPrompt) {
    const msg = document.createElement('div');
    msg.className = 'message assistant';
    msg.setAttribute('role', 'group');
    msg.setAttribute('aria-label', 'Assistant response');
    const lines = text.split('\n').filter(line => line.trim() !== '');
    lines.forEach((line, index) => {
        const div = document.createElement('div');
        div.className = 'assistant-line';
        div.setAttribute('role', 'text');
        div.textContent = line.trim();
        msg.appendChild(div);
    });
    chat.appendChild(msg);
    chat.scrollTop = chat.scrollHeight;

    // Long press events
    msg.addEventListener('touchstart', (e) => startLongPress(e, msg, originalPrompt));
    msg.addEventListener('mousedown', (e) => startLongPress(e, msg, originalPrompt));
    msg.addEventListener('touchend', cancelLongPress);
    msg.addEventListener('mouseup', cancelLongPress);
}

// Long press handlers
function startLongPress(e, msg, prompt) {
    e.preventDefault();
    selectedAssistantText = Array.from(msg.querySelectorAll('.assistant-line')).map(div => div.textContent).join('\n');
    selectedPrompt = prompt;
    longPressTimer = setTimeout(() => {
        openActionMenu(e);
    }, 600);
}

function cancelLongPress() {
    clearTimeout(longPressTimer);
}

// Open action menu
function openActionMenu(e) {
    actionMenu.style.display = 'block';
    actionMenu.style.left = `${e.pageX}px`;
    actionMenu.style.top = `${e.pageY}px`;
    actionMenu.focus();
}

// Close action menu
document.body.addEventListener('click', (e) => {
    if (!actionMenu.contains(e.target)) {
        actionMenu.style.display = 'none';
    }
});

// Copy button
copyBtn.onclick = () => {
    navigator.clipboard.writeText(selectedAssistantText).then(() => alert('Copied to clipboard!'));
    actionMenu.style.display = 'none';
};

// Share button
shareBtn.onclick = () => {
    if (navigator.share) {
        navigator.share({ text: selectedAssistantText }).catch(console.error);
    } else {
        alert('Sharing not supported.');
    }
    actionMenu.style.display = 'none';
};

// Regenerate button
regenerateBtn.onclick = () => {
    promptInput.value = selectedPrompt;
    sendBtn.click();
    actionMenu.style.display = 'none';
};

// Voice Input
voiceInputBtn.onclick = () => {
    if (!('webkitSpeechRecognition' in window)) {
        alert('Voice input not supported.');
        return;
    }
    const recognition = new webkitSpeechRecognition();
    recognition.lang = 'en-US';
    recognition.start();
    recognition.onresult = (event) => {
        const voiceText = event.results[0][0].transcript;
        promptInput.value = voiceText;
    };
    recognition.onend = () => {
        if (promptInput.value.trim()) {
            sendBtn.click();
        }
    };
};
</script>

</body>
</html>
