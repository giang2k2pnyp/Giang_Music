<link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css">

	<footer>
		<div class="footer-div">
			<ul>
				<li><a href="<?=ROOT?>/home">Trang chủ</a></li>
				<li><a href="<?=ROOT?>/music">Bài hát</a></li>
				<li><a href="<?=ROOT?>/about">Thông tin</a></li>
				<li><a href="<?=ROOT?>/contact">Liên hệ</a></li>
				
				<?php if(!logged_in()):?>
					<li><a href="<?=ROOT?>/login">Đăng nhập</a></li>
				<?php endif;?>

			</ul>
		</div>
		<div class="footer-div">
			<form action="<?=ROOT?>/search">
				<div class="form-group">
					<input class="form-control" type="text" placeholder="Search for music" name="find">
					<button class="btn">Tìm kiếm</button>
				</div>
			</form>
		</div>
		<div class="footer-div">
			Follow us:
			<br><br>
			<svg width="25" height="25" fill="white" class="bi bi-facebook" viewBox="0 0 16 16">
			  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
			</svg>
			<svg width="25" height="25" fill="white" class="bi bi-twitter" viewBox="0 0 16 16">
			  <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
			</svg>
			<svg width="25" height="25" fill="white" class="bi bi-instagram" viewBox="0 0 16 16">
			  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
			</svg>
		</div>
	</footer>

<script src="<?=ROOT?>/assets/js/menu-popper.js?35"></script>
</html>

<!-- Player toàn cục -->
<div id="global-player" style="display: none; position: fixed; bottom: 0; left: 0; right: 0; background: #222; padding: 10px; z-index: 1000; border-top: 1px solid #444;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
        <img id="global-player-thumbnail" src="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
        
        <div style="flex: 1; min-width: 100px;">
            <div id="global-player-title" style="font-weight: bold; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"></div>
            <div id="global-player-artist" style="font-size: 0.9em; color: #aaa;"></div>
        </div>
        
        <div style="display: flex; gap: 10px; align-items: center;">
            <button id="global-prev-btn" class="player-btn" title="Bài trước">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"></path>
                </svg>
            </button>
            
            <button id="global-play-btn" class="player-btn" title="Phát/Tạm dừng">
                <svg id="play-icon" width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M8 5v14l11-7z"></path>
                </svg>
                <svg id="pause-icon" width="20" height="20" viewBox="0 0 24 24" fill="white" style="display: none;">
                    <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path>
                </svg>
            </button>
            
            <button id="global-next-btn" class="player-btn" title="Bài sau">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"></path>
                </svg>
            </button>
        </div>
        
        <audio id="global-player-audio" style="flex: 2; min-width: 200px;"></audio>
        
        <!-- Phần điều khiển âm lượng -->
        <div style="display: flex; align-items: center; gap: 8px; min-width: 120px;">
            <button id="volume-toggle" class="player-btn" title="Tắt tiếng">
                <svg id="volume-high-icon" width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"></path>
                </svg>
                <svg id="volume-mute-icon" width="20" height="20" viewBox="0 0 24 24" fill="white" style="display: none;">
                    <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"></path>
                </svg>
            </button>
            <input type="range" id="volume-control" min="0" max="1" step="0.01" value="1" style="width: 80px;">
        </div>
        
        <div style="min-width: 100px; text-align: center; color: #aaa; font-size: 0.9em;">
            <span id="current-time">0:00</span> / 
            <span id="total-time">0:00</span>
        </div>
        
        <button id="global-close-btn" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.2em;" title="Đóng player">
            &times;
        </button>
    </div>
</div>

<script>
// Hằng số ROOT (cần khai báo trước nếu chưa có)
if (typeof ROOT === 'undefined') {
    window.ROOT = '<?= ROOT ?>';
}

// Đối tượng quản lý player toàn cục
window.globalPlayer = {
    playlist: [],
    currentIndex: 0,
    isPlaying: false,
    volume: 1,
    isMuted: false
};

// Khởi tạo player khi trang tải
document.addEventListener('DOMContentLoaded', function() {
    const player = document.getElementById('global-player-audio');
    const volumeControl = document.getElementById('volume-control');
    
    // Khôi phục trạng thái từ sessionStorage
    const savedState = sessionStorage.getItem('globalPlayerState');
    if (savedState) {
        try {
            const state = JSON.parse(savedState);
            window.globalPlayer = state;
            
            // Nếu có playlist đang phát, hiển thị player
            if (state.playlist.length > 0) {
                document.getElementById('global-player').style.display = 'block';
                updatePlayerUI(state.currentIndex);
                
                // Áp dụng cài đặt âm lượng
                player.volume = state.volume;
                volumeControl.value = state.volume;
                updateVolumeIcons(state.isMuted);
                
                // Nếu đang phát, tiếp tục phát
                if (state.isPlaying) {
                    player.play().catch(e => console.log("Autoplay error:", e));
                    document.getElementById('play-icon').style.display = 'none';
                    document.getElementById('pause-icon').style.display = 'inline';
                }
            }
        } catch (e) {
            console.error("Error parsing player state:", e);
        }
    }
    
    // Gắn sự kiện cho nút điều khiển
    document.getElementById('global-play-btn').addEventListener('click', togglePlay);
    document.getElementById('global-prev-btn').addEventListener('click', playPrev);
    document.getElementById('global-next-btn').addEventListener('click', playNext);
    document.getElementById('global-close-btn').addEventListener('click', closePlayer);
    
    // Sự kiện cho điều khiển âm lượng
    volumeControl.addEventListener('input', function() {
        const volume = parseFloat(this.value);
        player.volume = volume;
        window.globalPlayer.volume = volume;
        
        // Tự động bật/tắt mute khi điều chỉnh volume
        if (volume === 0) {
            player.muted = true;
            window.globalPlayer.isMuted = true;
        } else if (window.globalPlayer.isMuted) {
            player.muted = false;
            window.globalPlayer.isMuted = false;
        }
        
        updateVolumeIcons(window.globalPlayer.isMuted);
        savePlayerState();
    });
    
    // Sự kiện cho nút mute
    document.getElementById('volume-toggle').addEventListener('click', function() {
        window.globalPlayer.isMuted = !window.globalPlayer.isMuted;
        player.muted = window.globalPlayer.isMuted;
        updateVolumeIcons(window.globalPlayer.isMuted);
        savePlayerState();
    });
    
    // Cập nhật thời gian
    player.addEventListener('timeupdate', function() {
        document.getElementById('current-time').textContent = formatTime(player.currentTime);
    });
    
    player.addEventListener('loadedmetadata', function() {
        document.getElementById('total-time').textContent = formatTime(player.duration);
    });
    
    player.addEventListener('ended', playNext);
});

// Cập nhật biểu tượng âm lượng
function updateVolumeIcons(isMuted) {
    if (isMuted) {
        document.getElementById('volume-high-icon').style.display = 'none';
        document.getElementById('volume-mute-icon').style.display = 'inline';
    } else {
        document.getElementById('volume-high-icon').style.display = 'inline';
        document.getElementById('volume-mute-icon').style.display = 'none';
    }
}

// Hàm bật/tắt phát nhạc
function togglePlay() {
    const player = document.getElementById('global-player-audio');
    
    if (window.globalPlayer.isPlaying) {
        player.pause();
        document.getElementById('play-icon').style.display = 'inline';
        document.getElementById('pause-icon').style.display = 'none';
    } else {
        player.play().catch(e => console.log("Play error:", e));
        document.getElementById('play-icon').style.display = 'none';
        document.getElementById('pause-icon').style.display = 'inline';
    }
    
    window.globalPlayer.isPlaying = !window.globalPlayer.isPlaying;
    savePlayerState();
}

// Hàm để bắt đầu phát một playlist (gọi từ bất kỳ trang nào)
window.playGlobalPlaylist = function(playlist, startIndex = 0) {
    if (playlist.length === 0) return;
    
    window.globalPlayer = {
        playlist: playlist,
        currentIndex: startIndex,
        isPlaying: true,
        volume: window.globalPlayer.volume || 1,
        isMuted: window.globalPlayer.isMuted || false
    };
    
    document.getElementById('global-player').style.display = 'block';
    updatePlayerUI(startIndex);
    
    // Áp dụng cài đặt âm lượng
    const player = document.getElementById('global-player-audio');
    player.volume = window.globalPlayer.volume;
    player.muted = window.globalPlayer.isMuted;
    document.getElementById('volume-control').value = window.globalPlayer.volume;
    updateVolumeIcons(window.globalPlayer.isMuted);
    
    savePlayerState();
    
    // Tự động phát
    player.play().catch(e => console.log("Autoplay blocked:", e));
    document.getElementById('play-icon').style.display = 'none';
    document.getElementById('pause-icon').style.display = 'inline';
};

// Cập nhật giao diện player
function updatePlayerUI(index) {
    const song = window.globalPlayer.playlist[index];
    if (!song) return;
    
    document.getElementById('global-player-title').textContent = song.title;
    document.getElementById('global-player-artist').textContent = song.artist_name;
    document.getElementById('global-player-thumbnail').src = ROOT + '/' + song.image;
    
    const player = document.getElementById('global-player-audio');
    player.src = ROOT + '/' + song.file;
    player.load();
}

// Chuyển bài tiếp theo
function playNext() {
    const newIndex = (window.globalPlayer.currentIndex + 1) % window.globalPlayer.playlist.length;
    window.globalPlayer.currentIndex = newIndex;
    updatePlayerUI(newIndex);
    savePlayerState();
    
    const player = document.getElementById('global-player-audio');
    player.play();
    document.getElementById('play-icon').style.display = 'none';
    document.getElementById('pause-icon').style.display = 'inline';
}

// Chuyển bài trước
function playPrev() {
    const newIndex = (window.globalPlayer.currentIndex - 1 + window.globalPlayer.playlist.length) % window.globalPlayer.playlist.length;
    window.globalPlayer.currentIndex = newIndex;
    updatePlayerUI(newIndex);
    savePlayerState();
    
    const player = document.getElementById('global-player-audio');
    player.play();
    document.getElementById('play-icon').style.display = 'none';
    document.getElementById('pause-icon').style.display = 'inline';
}

// Đóng player
function closePlayer() {
    document.getElementById('global-player').style.display = 'none';
    const player = document.getElementById('global-player-audio');
    player.pause();
    player.src = '';
    
    // Reset state
    window.globalPlayer = {
        playlist: [],
        currentIndex: 0,
        isPlaying: false,
        volume: window.globalPlayer.volume || 1,
        isMuted: window.globalPlayer.isMuted || false
    };
    
    // Xóa sessionStorage
    sessionStorage.removeItem('globalPlayerState');
}

// Lưu trạng thái player
function savePlayerState() {
    sessionStorage.setItem('globalPlayerState', JSON.stringify(window.globalPlayer));
}

// Định dạng thời gian
function formatTime(seconds) {
    const min = Math.floor(seconds / 60);
    const sec = Math.floor(seconds % 60);
    return `${min}:${sec < 10 ? '0' : ''}${sec}`;
}
</script>

<style>
.player-btn {
    background: #333;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s;
}

.player-btn:hover {
    background: #444;
    transform: scale(1.05);
}

.player-btn svg {
    width: 20px;
    height: 20px;
}

#global-player audio {
    height: 40px;
}

/* Style cho thanh điều chỉnh âm lượng */
#volume-control {
    -webkit-appearance: none;
    height: 5px;
    background: #555;
    border-radius: 5px;
    outline: none;
    cursor: pointer;
    transition: background-color 0.2s;
}

#volume-control:hover {
    background: #666;
}

#volume-control::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background: #fff;
    cursor: pointer;
    transition: background-color 0.2s;
}

#volume-control::-webkit-slider-thumb:hover {
    background: #1db954;
}

#volume-control::-moz-range-thumb {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background: #fff;
    cursor: pointer;
    border: none;
    transition: background-color 0.2s;
}

#volume-control::-moz-range-thumb:hover {
    background: #1db954;
}

/* Responsive cho mobile */
@media (max-width: 768px) {
    #global-player > div {
        gap: 10px;
    }
    
    #global-player-thumbnail {
        width: 40px;
        height: 40px;
    }
    
    .player-btn {
        width: 35px;
        height: 35px;
    }
    
    #global-player audio {
        min-width: 150px;
    }
    
    #volume-control {
        width: 60px;
    }
}
</style>