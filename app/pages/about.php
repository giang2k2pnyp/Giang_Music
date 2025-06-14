<?php require page('includes/header')?>
<link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css">

<div class="about-container">
    <div class="about-content">
        <div class="breadcrumb">
            <a href="<?=ROOT?>">Trang chủ</a> / 
            <a href="<?=ROOT?>/music">Bài hát</a> / 
            <a href="<?=ROOT?>/login">Đăng nhập</a> / 
            <a href="<?=ROOT?>/signup">Đăng ký</a>
        </div>

        <h1>Về Giang Music</h1>
        
        <div class="about-section">
            <div class="about-text">
                <h2>Câu Chuyện Của Chúng Tôi</h2>
                <p>
                    Thành lập năm 2025, Giang Music bắt đầu từ niềm đam mê âm nhạc của Nguyễn Trường Giang.
                    Từ bộ sưu tập nhỏ các nghệ sĩ cả nước, chúng tôi đã phát triển thành nền tảng kết nối
                    người yêu nhạc với các nghệ sĩ tài năng khắp thế giới.
                </p>
                <p>
                    Chúng tôi tin âm nhạc có sức mạnh vượt qua mọi ranh giới. Sứ mệnh của chúng tôi là tạo không gian
                    để nghệ sĩ ở mọi cấp độ chia sẻ tác phẩm với công chúng toàn cầu.
                </p>
            </div>
            <div class="about-image">
                <img src="<?=ROOT?>/assets/images/Giang_Music.png" alt="Phòng thu Giang Music">
            </div>
        </div>
        
        <div class="about-section reverse">
            <div class="about-text">
                <h2>Dịch Vụ Của Chúng Tôi</h2>
                <ul>
                    <li>🎵 Kho nhạc đa dạng với hàng ngàn bài hát</li>
                    <li>🎤 Nền tảng cho nghệ sĩ độc lập</li>
                    <li>🎧 Phát nhạc chất lượng cao</li>
                    <li>📱 Dùng được trên mọi thiết bị</li>
                    <li>🎛️ Playlist theo tâm trạng</li>
                    <li>🎼 Nội dung độc quyền</li>
                </ul>
            </div>
            <div class="about-image">
                <img src="<?=ROOT?>/assets/images/background1.png" alt="Bộ sưu tập âm nhạc">
            </div>
        </div>
        
        <div class="mission-section">
            <h2>Sứ Mệnh Của Chúng Tôi</h2>
            <div class="mission-cards">
                <div class="mission-card">
                    <div class="icon">❤️</div>
                    <h3>Phục Vụ Người Nghe</h3>
                    <p>Mang đến trải nghiệm khám phá âm nhạc tuyệt vời</p>
                </div>
                <div class="mission-card">
                    <div class="icon">🌍</div>
                    <h3>Kết Nối Toàn Cầu</h3>
                    <p>Gắn kết người yêu nhạc xuyên biên giới</p>
                </div>
            </div>
        </div>
        
        <div class="team-section">
            <h2>Đội Ngũ Chúng Tôi</h2>
            <div class="team-members">
                <div class="team-member">
                    <img src="<?=ROOT?>/assets/images/Giang.png" alt="Nguyen Van Giang">
                    <h3>Nguyễn Trường Giang</h3>
                    <p>Lập trình viên và Admin website</p>
                </div>
            </div>
        </div>
        
        <div class="cta-section">
            <h2>Tham Gia Cùng Chúng Tôi</h2>
            <p>Trở thành phần của cộng đồng âm nhạc đang phát triển</p>
            <div class="cta-buttons">
                <a href="<?=ROOT?>/signup" class="btn-primary">Đăng ký Miễn phí</a>
                <a href="<?=ROOT?>/artists" class="btn-secondary">Dành cho Nghệ sĩ</a>
            </div>
        </div>
    </div>
</div>

<?php require page('includes/footer')?>