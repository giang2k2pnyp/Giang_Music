<?php 


function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

function page($file)
{

	return "../app/pages/".$file.".php";
}

function db_connect()
{
	$string = DBDRIVER.":hostname=".DBHOST.";dbname=".DBNAME;
	$con = new PDO($string, DBUSER, DBPASS);

	return $con;
}

function db_query($query, $data = array(), $return_id = false)
{
	$con = db_connect();
	$stm = $con->prepare($query);

	if($stm)
	{
		$check = $stm->execute($data);
		if($check){
			if ($return_id) {
                return $con->lastInsertId();
            }

			$result = $stm->fetchAll(PDO::FETCH_ASSOC);
            if(is_array($result) && count($result) > 0)
            {
                return $result;
            }
		}
	}
	return false;
}

function db_query_one($query, $data = array())
{
	$con = db_connect();

	$stm = $con->prepare($query);
	if($stm)
	{
		$check = $stm->execute($data);
		if($check){
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);

			if(is_array($result) && count($result) > 0)
			{
				return $result[0];
			}
		}
	}
	return false;
}

function message($message = '', $clear = false)
{
	if(!empty($message)){
		$_SESSION['message'] = $message;
	}else{

		if(!empty($_SESSION['message'])){

			$msg = $_SESSION['message'];
			if($clear){
				unset($_SESSION['message']);
			}
			return $msg;
		}

	}
	return false;
}

function redirect($page)
{
	// Nếu $page đã là URL tuyệt đối, thì dùng luôn
	if (preg_match("/^https?:\/\//", $page)) {
		header("Location: " . $page);
	} else {
		header("Location: " . ROOT . "/" . ltrim($page, '/'));
	}
	// header("Location: ".ROOT."/".$page);
	die();
	exit();
}

function set_value($key, $default = '')
{
	if(!empty($_POST[$key]))
	{
		return $_POST[$key];
	}else{

		return $default;
	}

	return '';
}

function set_select($key, $value, $default = '')
{
	if(!empty($_POST[$key]))
	{
		if($_POST[$key] == $value){
			return " selected ";
		}
	}else{
		if($default == $value){
			return " selected ";
		}
	}

	return '';
}

function get_date($date)
{
	return date("jS M, Y",strtotime($date));
}

function logged_in()
{

	if(!empty($_SESSION['USER']) && is_array($_SESSION['USER'])){
		return true;
	}

	return false;
}

function is_admin()
{

	if(!empty($_SESSION['USER']['role']) && $_SESSION['USER']['role'] == 'admin'){
		return true;
	}

	return false;
}

function user($column)
{
	if(!empty($_SESSION['USER'][$column])){
		return $_SESSION['USER'][$column];
	}

	return "Unknown";
}

function authenticate($row)
{
	$_SESSION['USER'] = $row;
}

function str_to_url($url)
{

	$url = str_replace("'", "", $url);
   	$url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
   	$url = trim($url, "-");
   	$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
   	$url = strtolower($url);
   	$url = preg_replace('~[^-a-z0-9_]+~', '', $url);
   	
   	return $url;
}

function get_category($id)
{
	$query = "select category from categories where id = :id limit 1";
	$row = db_query_one($query,['id'=>$id]);

	if(!empty($row['category']))
	{
		return $row['category'];
	}

	return "Unknown";
}

function esc($str)
{
	return nl2br(htmlspecialchars($str));
}

function get_artist($id)
{
	$query = "select name from artists where id = :id limit 1";
	$row = db_query_one($query,['id'=>$id]);

	if(!empty($row['name']))
	{
		return $row['name'];
	}

	return "Unknown";
}

// Lấy danh sách phát của user
function get_user_playlists($user_id = null) {
    if ($user_id === null && logged_in()) {
        $user_id = user('id');
    }
    $query = "SELECT * FROM list_song WHERE create_by = :create_by ORDER BY date_create DESC";
    return db_query($query, ['create_by' => $user_id]);
}

// Kiểm tra bài hát đã có trong playlist
function song_in_playlist($list_id, $song_id) {
    $query = "SELECT id FROM playlist_songs WHERE list_id = :list_id AND song_id = :song_id LIMIT 1";
    $result = db_query_one($query, ['list_id' => $list_id, 'song_id' => $song_id]);
    return !empty($result);
}

// Thêm bài hát vào playlist
function add_song_to_playlist($list_id, $song_id) {
    if (song_in_playlist($list_id, $song_id)) return false;

	$con = db_connect();
    $stm = $con->prepare("INSERT INTO playlist_songs (list_id, song_id) VALUES (:list_id, :song_id)");
    $result = $stm->execute(['list_id' => $list_id, 'song_id' => $song_id]);
	// Nếu đây là bài hát đầu tiên và playlist chưa có ảnh, cập nhật ảnh từ bài hát
    if ($result) {
        $playlist = get_playlist_info($list_id);
		// Kiểm tra nếu playlist đang dùng ảnh mặc định
        if ($playlist && $playlist['image'] == 'uploads/Giang_Music.png') {
            $song = db_query_one("SELECT image FROM songs WHERE id = :id", ['id' => $song_id]);
			if ($song && !empty($song['image'])) {
                db_query("UPDATE list_song SET image = :image WHERE id = :id", [
                    'image' => $song['image'],
                    'id' => $list_id
                ]);
            }
        }
    }
	return $result;
}

// Tạo playlist mới
// function create_playlist($name, $description = '') {
//     if (!logged_in()) return false;
    
//     $query = "INSERT INTO list_song (name_list, create_by, description) 
//               VALUES (:name, :user_id, :description)";
//     $con = db_connect();
//     $stm = $con->prepare($query);
//     return $stm->execute([
//         'name' => $name,
//         'user_id' => user('id'),
//         'description' => $description
//     ]);
// }

// Tạo danh sách mới
function create_playlist($name, $description = '', $image = 'uploads/Giang_Music.png') {
    if (!logged_in()) return false;

    try {
        $query = "INSERT INTO list_song (name_list, create_by, date_create, description, image) 
                  VALUES (:name_list, :create_by, NOW(), :description, :image)";
        $con = db_connect();
        $stm = $con->prepare($query);

        $data = [
            'name_list' => $name,
            'create_by' => user('id'),
            'description' => $description,
            'image' => $image
        ];

        $result = $stm->execute($data);
        return $result ? $con->lastInsertId() : false;
    } catch (Exception $e) {
        error_log("Error creating playlist: " . $e->getMessage());
        return false;
    }
}

// Lấy thông tin playlist
function get_playlist_info($playlist_id) {
    $query = "SELECT ls.*, u.username 
              FROM list_song ls 
              LEFT JOIN users u ON ls.create_by = u.id 
              WHERE ls.id = :id LIMIT 1";
    return db_query_one($query, ['id' => $playlist_id]);
}

// Lấy danh sách bài hát trong playlist
function get_playlist_songs($playlist_id) {
    $query = "SELECT s.*, a.name as artist_name 
              FROM playlist_songs ps 
              JOIN songs s ON ps.song_id = s.id 
              JOIN artists a ON s.artist_id = a.id 
              WHERE ps.list_id = :list_id 
              ORDER BY ps.date_added DESC";
    return db_query($query, ['list_id' => $playlist_id]);
}

// Đếm số bài hát trong playlist
function count_playlist_songs($playlist_id) {
    $query = "SELECT COUNT(*) as count FROM playlist_songs WHERE list_id = :list_id";
    $result = db_query_one($query, ['list_id' => $playlist_id]);
    return $result ? $result['count'] : 0;
}

// Xóa bài hát khỏi playlist
function remove_song_from_playlist($list_id, $song_id) {
    $query = "DELETE FROM playlist_songs WHERE list_id = :list_id AND song_id = :song_id LIMIT 1";
    $con = db_connect();
    $stm = $con->prepare($query);
    return $stm->execute(['list_id' => $list_id, 'song_id' => $song_id]);
}

// Cập nhật thông tin playlist
function update_playlist($playlist_id, $name, $description) {
    $query = "UPDATE list_song 
              SET name_list = :name, description = :description 
              WHERE id = :id LIMIT 1";
    $con = db_connect();
    $stm = $con->prepare($query);
    return $stm->execute([
        'name' => $name,
        'description' => $description,
        'id' => $playlist_id
    ]);
}

// Xóa playlist
function delete_playlist($playlist_id) {
    $con = db_connect();
    
    try {
        // Bắt đầu transaction
        $con->beginTransaction();
        
        // 1. Xóa các bài hát trong playlist
        $query1 = "DELETE FROM playlist_songs WHERE list_id = :list_id";
        $stm1 = $con->prepare($query1);
        $stm1->execute(['list_id' => $playlist_id]);
        
        // 2. Xóa playlist
        $query2 = "DELETE FROM list_song WHERE id = :id";
        $stm2 = $con->prepare($query2);
        $stm2->execute(['id' => $playlist_id]);
        
        $con->commit();
        return $stm2->rowCount() > 0;
    } catch (Exception $e) {
        if ($con->inTransaction()) {
            $con->rollBack();
        }
        error_log("Error deleting playlist: " . $e->getMessage());
        return false;
    }
}

// Xử lý xóa playlist từ AJAX
if (isset($_GET['action']) && $_GET['action'] == 'delete_playlist' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    
    // Kiểm tra quyền
    $playlist = get_playlist_info($id);
    if (!$playlist || !logged_in() || ($playlist['create_by'] != user('id') && !is_admin())) {
        echo json_encode(['success' => false, 'message' => 'Không có quyền xóa playlist này']);
        exit;
    }
    
    if (delete_playlist($id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Xóa playlist thất bại']);
    }
    exit;
}
