<?php
if (user('role') !== 'admin') {
    redirect('login');
}

$thread_id = (int)$_GET['thread_id'] ?? 0;

// THÊM KIỂM TRA NẾU KHÔNG CÓ THREAD_ID
if (!$thread_id) {
    message("Thread not found");
    redirect('admin/messages');
}

// Xử lý gửi phản hồi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    
    if (!empty($message)) {
        db_query("INSERT INTO messages (user_id, thread_id, message) VALUES (?, ?, ?)", 
                [user('id'), $thread_id, $message]);
        
        // Đánh dấu đã đọc
        db_query("UPDATE threads SET is_read = 1, updated_at = NOW() WHERE id = ?", [$thread_id]);
        
        redirect("admin/reply?thread_id=$thread_id");
    }
}

// Lấy toàn bộ hội thoại
$messages = db_query("
    SELECT m.*, u.username, u.email 
    FROM messages m
    JOIN users u ON m.user_id = u.id
    WHERE m.thread_id = ?
    ORDER BY m.created_at ASC
", [$thread_id]);

// Đánh dấu đã đọc
db_query("UPDATE messages SET is_read = 1 WHERE thread_id = ?", [$thread_id]);
db_query("UPDATE threads SET is_read = 1 WHERE id = ?", [$thread_id]);
?>

<?php require page('includes/admin-header')?>

<div class="admin-container">
    <h1>Conversation Thread</h1>
    <a href="<?=ROOT?>/admin/messages">Back to messages</a>

    <div class="message-list">
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message-item <?=!$msg['is_read'] && $msg['user_id'] != user('id') ? 'unread' : ''?>">
                    <div class="message-header">
                        <strong><?=esc($msg['username'])?> (<?=esc($msg['email'])?>)</strong>
                        <span><?=date("M d, Y H:i", strtotime($msg['created_at']))?></span>
                    </div>
                    <div class="message-content">
                        <?=nl2br(esc($msg['message']))?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages found</p>
        <?php endif; ?>
    </div>  

    <!-- Form phản hồi -->
    <div class="reply-form">
        <form method="POST">
            <div class="form-group">
                <label for="message">Reply:</label>
                <textarea 
                    id="message" 
                    name="message" 
                    rows="3" 
                    placeholder="Type your reply here..." 
                    required
                ></textarea>
            </div>
            <button type="submit" class="btn">Send Reply</button>
        </form>
    </div>
</div>

<style>
.reply-form {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}
</style>

<?php require page('includes/admin-footer')?>