<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config/db.php';
$active_condition = isset($_SESSION['active_condition']) ? $_SESSION['active_condition']['name'] : 'Healthy Person';
include_once __DIR__ . '/includes/navbar.php';
?>

<main class="py-5" style="background-color: var(--bg-analyzer); min-height: 80vh;">
    <div class="container container-desktop">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="upload-container-card p-0 d-flex flex-column h-100" style="overflow: hidden; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                    <!-- Chat Header -->
                    <div class="p-4 d-flex align-items-center" style="background-color: #1b3322; color: white;">
                        <img src="https://ui-avatars.com/api/?name=Dr+Medi&background=C8A400&color=fff&rounded=true" alt="Dr. Medi" class="me-3" style="width: 50px; height: 50px;">
                        <div>
                            <h4 class="m-0 fw-bold" style="font-family: var(--font-sans);">Dr. Medi</h4>
                            <p class="m-0" style="font-size: 13px; opacity: 0.8;">Clinical AI Nutritionist</p>
                        </div>
                        <div class="ms-auto text-end">
                            <span class="badge bg-light text-dark">Active Profile: <?php echo htmlspecialchars($active_condition); ?></span>
                        </div>
                    </div>

                    <!-- Chat History -->
                    <div class="p-4 flex-grow-1" id="chatBox" style="background-color: #f9fbf9; height: 400px; overflow-y: auto;">
                        <div class="d-flex mb-4">
                            <div class="me-3"><img src="https://ui-avatars.com/api/?name=Dr+Medi&background=C8A400&color=fff&rounded=true" width="40" height="40"></div>
                            <div class="p-3" style="background-color: #e8f5e9; border-radius: 12px 12px 12px 0; color: #1b3322;">
                                Hello! I am Dr. Medi. I see your current active health profile is <strong><?php echo htmlspecialchars($active_condition); ?></strong>. How can I assist you with your dietary plan today?
                            </div>
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <div class="p-3 border-top" style="background-color: white;">
                        <form id="chatForm" class="d-flex align-items-center">
                            <input type="text" id="chatInput" class="form-control me-2 py-2" placeholder="Ask about your diet or health condition..." style="border-radius: 20px;" required>
                            <button type="submit" class="btn btn-analyze py-2 px-4" style="border-radius: 20px; border-radius: 20px; white-space: nowrap;">
                                <i class="fa-solid fa-paper-plane"></i> Send
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const input = document.getElementById('chatInput');
    const msg = input.value.trim();
    if(!msg) return;
    
    appendMessage('You', msg, true);
    input.value = '';
    
    // Add loading typing indicator
    const chatBox = document.getElementById('chatBox');
    const loadingId = 'loading-' + Date.now();
    chatBox.innerHTML += `
        <div class="d-flex mb-4" id="${loadingId}">
            <div class="me-3"><img src="https://ui-avatars.com/api/?name=Dr+Medi&background=C8A400&color=fff&rounded=true" width="40" height="40"></div>
            <div class="p-3 text-muted" style="background-color: #e8f5e9; border-radius: 12px 12px 12px 0;">
                <i class="fa-solid fa-ellipsis fa-fade"></i> Dr. Medi is typing...
            </div>
        </div>
    `;
    chatBox.scrollTop = chatBox.scrollHeight;

    const formData = new FormData();
    formData.append('message', msg);
    formData.append('persona', 'dr_medi');

    fetch('api/chat.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
        document.getElementById(loadingId).remove();
        if(data.status === 'success') {
            appendMessage('Dr. Medi', data.reply, false);
        } else {
            appendMessage('System', 'Error connecting to AI.', false);
        }
    }).catch(err => {
        document.getElementById(loadingId).remove();
        appendMessage('System', 'Connection failed.', false);
    });
});

function appendMessage(sender, text, isUser) {
    const chatBox = document.getElementById('chatBox');
    const bg = isUser ? '#1b3322' : '#e8f5e9';
    const color = isUser ? '#fff' : '#1b3322';
    const radius = isUser ? '12px 12px 0 12px' : '12px 12px 12px 0';
    const align = isUser ? 'justify-content-end' : '';
    const avatarStr = isUser ? '' : `<div class="me-3"><img src="https://ui-avatars.com/api/?name=Dr+Medi&background=C8A400&color=fff&rounded=true" width="40" height="40"></div>`;
    
    // Parse markdown if it's the bot responding
    const htmlContent = isUser ? text : marked.parse(text);

    const html = `
        <div class="d-flex mb-4 ${align}">
            ${avatarStr}
            <div class="p-3" style="background-color: ${bg}; color: ${color}; border-radius: ${radius}; max-width: 80%;">
                ${htmlContent}
            </div>
        </div>
    `;
    chatBox.innerHTML += html;
    chatBox.scrollTop = chatBox.scrollHeight;
}
</script>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
