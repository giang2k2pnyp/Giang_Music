<?php
require_once __DIR__ . '/../core/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && logged_in()) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    
    $playlist = get_playlist_info($id);
    
    if ($playlist && ($playlist['create_by'] == user('id') || is_admin())) {
        if (delete_playlist($id)) {
            echo json_encode(['success' => true]);
        } else {
            // Thêm thông báo lỗi chi tiết
            error_log("Delete failed for playlist ID: $id");
            echo json_encode([
                'success' => false, 
                'message' => 'Xóa playlist thất bại. Vui lòng thử lại sau.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Không có quyền xóa playlist này'
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Yêu cầu không hợp lệ'
    ]);
}