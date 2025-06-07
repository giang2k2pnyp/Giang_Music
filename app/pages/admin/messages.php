<?php
// Kiểm tra quyền admin
if (user('role') !== 'admin') {
    redirect('login');
}

// Đánh dấu đã đọc khi xem
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    db_query("UPDATE messages SET is_read = 1 WHERE id = ?", [$id]);
}

// Lấy danh sách hội thoại
$threads = db_query("
    SELECT t.*, u.username, u.email, 
           (SELECT COUNT(*) FROM messages WHERE thread_id = t.id AND is_read = 0 AND user_id != ?) AS unread_count
    FROM threads t
    JOIN users u ON t.user_id = u.id
    ORDER BY t.updated_at DESC
", [user('id')]);
?>

<?php require page('includes/admin-header')?>

<div class="admin-container">
    <h1>Conversations</h1>
    
    <div class="thread-list">
        <?php if (!empty($threads)): ?>
            <?php foreach ($threads as $thread): ?>
                <a href="<?=ROOT?>/admin/reply?thread_id=<?=$thread['id']?>" class="thread-item <?=$thread['unread_count'] > 0 ? 'unread' : ''?>">
                    <div class="thread-header">
                        <strong><?=esc($thread['username'])?> (<?=esc($thread['email'])?>)</strong>
                        <span><?=date("M d, Y H:i", strtotime($thread['updated_at']))?></span>
                    </div>
                    <div class="thread-info">
                        Messages: <?=$thread['message_count']?> 
                        <?php if ($thread['unread_count'] > 0): ?>
                            <span class="badge"><?=$thread['unread_count']?></span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No conversations found</p>
        <?php endif; ?>
    </div>
</div>

<style>
.thread-list {
    margin-top: 20px;
}

.thread-item {
    display: block;
    padding: 15px;
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

.thread-info {
    font-size: 0.9em;
    color: #666;
}

/* Di chuột đổi màu */
.thread-item:hover {
    background-color: #f9f9f9;
}
</style>

<?php require page('includes/admin-footer')?>