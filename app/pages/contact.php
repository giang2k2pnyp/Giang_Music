<?php
// Kiểm tra đăng nhập
if (!logged_in()) {
    message("You need to login to contact admin");
    redirect('login');
}

// Xử lý gửi tin nhắn
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    $thread_id = $_POST['thread_id'] ?? 0;
    
    if (!empty($message)) {
        // Tạo thread mới nếu không có thread_id
        if (empty($thread_id)) {
            $thread_id = db_query(
                "INSERT INTO threads (user_id) VALUES (?)", 
                [user('id')], 
                true
            );
            
            if (!$thread_id) {
                message("Failed to create conversation thread");
                redirect('contact');
            }
        }
        $query = "INSERT INTO messages (user_id, thread_id, message) VALUES (?, ?, ?)";
        db_query($query, [user('id'), $thread_id, $message]);
        db_query("UPDATE threads SET message_count = message_count + 1 WHERE id = ?", [$thread_id]);
        
        message("Your message has been sent to admin!");
        redirect('contact');
    } else {
        $errors[] = "Message cannot be empty";
    }
}

// Kiểm tra nếu có thread_id trong URL
$current_thread_id = $_GET['thread_id'] ?? 0;
$show_thread = $current_thread_id > 0;

// Lấy lịch sử hội thoại
$user_id = user('id');
$threads = db_query("
    SELECT 
        t.id, 
        t.created_at, 
        (SELECT m.message FROM messages m WHERE m.thread_id = t.id ORDER BY m.created_at DESC LIMIT 1) as last_message,
        (SELECT COUNT(*) FROM messages WHERE thread_id = t.id AND is_read = 0 AND user_id != $user_id) AS unread_count
    FROM threads t
    WHERE t.user_id = $user_id
    ORDER BY t.created_at DESC
");

// Nếu đang xem một hội thoại cụ thể
$thread_messages = [];
if ($show_thread) {
    db_query("UPDATE messages SET is_read = 1 WHERE thread_id = ? AND user_id != ?", [$current_thread_id, user('id')]);
    db_query("UPDATE threads SET is_read = 1 WHERE id = ?", [$current_thread_id]);

    $thread_messages = db_query("
        SELECT m.*, u.username, u.email 
        FROM messages m
        JOIN users u ON m.user_id = u.id
        WHERE m.thread_id = ?
        ORDER BY m.created_at ASC
    ", [$current_thread_id]);
}
?>

<?php require page('includes/header')?>

<div class="contact-container">
    <h1>Liên hệ Admin</h1>
    <?php if ($show_thread): ?>
        <!-- Hiển thị chi tiết hội thoại -->
        <a href="<?=ROOT?>/contact">Trở lại hội thoại</a>
        <div class="message-list">
            <?php if (!empty($thread_messages)): ?>
                <?php foreach ($thread_messages as $msg): ?>
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
                <p>Không có tin nhắn trong hội thoại</p>
            <?php endif; ?>
        </div>

        <!-- Form phản hồi -->
        <div class="reply-form">
            <form method="POST">
                <input type="hidden" name="thread_id" value="<?=$current_thread_id?>">
                <div class="form-group">
                    <label for="message">Trả lời:</label>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="3" 
                        placeholder="Type your reply here..." 
                        required
                    ></textarea>
                </div>
                <button type="submit" class="btn">Gửi</button>
            </form>
        </div>

    <?php else: ?>
        <!-- Hiển thị danh sách hội thoại -->
        <div class="conversation-history">
            <h3>Hội thoại của bạn</h3>
            <?php if (!empty($threads)): ?>
                <?php foreach ($threads as $thread): ?>
                    <a href="<?=ROOT?>/contact?thread_id=<?=$thread['id']?>" class="thread-item <?=$thread['unread_count'] > 0 ? 'unread' : ''?>">
                        <div class="thread-header">
                            <small><?=date("M d, Y H:i", strtotime($thread['created_at']))?></small>
                            <?php if ($thread['unread_count'] > 0): ?>
                                <span class="badge"><?=$thread['unread_count']?></span>
                            <?php endif; ?>
                        </div>
                        <p><?=esc($thread['last_message'])?></p>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không tìm thấy cuộc hội thoại</p>
            <?php endif; ?>
        </div>    
        
        <!-- Form gửi tin nhắn mới -->
        <form method="POST">
            <div class="form-group">
                <label for="message">Tin nhắn của bạn:</label>
                <textarea 
                    id="message" 
                    name="message" 
                    rows="5" 
                    placeholder="Type your message here..." 
                    required
                ></textarea>
            </div>
            <button type="submit" class="btn">Gửi tin nhắn</button>
        </form>
    <?php endif; ?>
</div>

<!-- Thêm CSS mới -->
<style>
.conversation-history {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #eee;
    border-radius: 4px;
}

.thread-item {
    display: block;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #eee;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
}

.thread-item.unread {
    background-color: #f0f8ff;
    border-left: 3px solid #2196F3;
}

.thread-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
}

.thread-item p {
    margin: 5px 0;
}

.badge {
    background: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 0.8em;
}

.message-list {
    margin-bottom: 20px;
}

.message-item {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #eee;
    border-radius: 4px;
}

.message-item.unread {
    background-color: #f0f8ff;
    border-left: 3px solid #2196F3;
}

.message-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
    font-size: 0.9em;
}

.message-content {
    padding: 5px 0;
}

.reply-form {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}
</style>	

<?php require page('includes/footer')?>