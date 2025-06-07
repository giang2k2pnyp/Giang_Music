<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = [];

    // Tên người dùng
    if (empty($_POST['username'])) {
        $errors['username'] = "Tên người dùng không được để trống";
    } else if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['username'])) {
        $errors['username'] = "Tên người dùng chỉ được chứa chữ cái và số, không có khoảng trắng";
    }

    // Email
    if (empty($_POST['email'])) {
        $errors['email'] = "Email không được để trống";
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email không hợp lệ";
    } else {
        // Check email tồn tại
        $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $email_check = db_query_one($query, ['email' => trim($_POST['email'])]);
        if ($email_check) {
            $errors['email'] = "Email đã được sử dụng";
        }
    }

    // Mật khẩu
    if (empty($_POST['password'])) {
        $errors['password'] = "Mật khẩu không được để trống";
    } else if ($_POST['password'] != $_POST['retype_password']) {
        $errors['password'] = "Mật khẩu không khớp";
    } else if (strlen($_POST['password']) < 8) {
        $errors['password'] = "Mật khẩu phải có ít nhất 8 ký tự";
    }

    // Nếu chưa có, tạo tài khoản
    if (empty($errors)) {
        $values = [
            'username' => trim($_POST['username']),
            'email'    => trim($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role'     => 'user',
            'date'     => date("Y-m-d H:i:s")
        ];

        $query = "INSERT INTO users (username, email, password, role, date) 
                  VALUES (:username, :email, :password, :role, :date)";
        
        $db_success = db_query($query, $values, true);

        if ($db_success) {
            // Tự động đăng nhập sau khi đăng ký
            $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $user = db_query_one($query, ['email' => $values['email']]);
            
            if ($user) {
                authenticate($user);
                message("Đăng ký và đăng nhập thành công!");
                redirect('home');
            } else {
                message("Đăng ký thành công! Vui lòng đăng nhập");
                redirect('login');
            }
        } else {
            message("Có lỗi xảy ra khi đăng ký. Vui lòng thử lại", 'error');
        }
    }
}
?>

<?php require page('includes/header')?>

<section class="content">
    <div class="login-holder">
        <?php if(message()):?>
            <div class="alert <?= (strpos(message(), 'thành công') !== false) ? 'success' : 'error' ?>">
                <?= message('', true) ?>
            </div>
        <?php endif;?>

        <form method="post">
            <center><img src="assets/images/logo.jpg" style="width: 150px;border-radius: 50%;border: solid thin #ccc;"></center>
            <h2>Đăng ký tài khoản</h2>
            
            <input value="<?= set_value('username') ?>" class="form-control my-1" type="text" name="username" placeholder="Tên người dùng">
            <?php if (!empty($errors['username'])): ?>
                <small class="error"><?= $errors['username'] ?></small>
            <?php endif; ?>

            <input value="<?= set_value('email') ?>" class="form-control my-1" type="email" name="email" placeholder="Email">
            <?php if (!empty($errors['email'])): ?>
                <small class="error"><?= $errors['email'] ?></small>
            <?php endif; ?>

            <input class="form-control my-1" type="password" name="password" placeholder="Mật khẩu">
            <?php if (!empty($errors['password'])): ?>
                <small class="error"><?= $errors['password'] ?></small>
            <?php endif; ?>

            <input class="form-control my-1" type="password" name="retype_password" placeholder="Nhập lại mật khẩu">
            
            <button class="my-1 btn bg-green">Đăng ký</button>
            
            <div class="my-2 text-center">
                Đã có tài khoản? <a href="<?= ROOT ?>/login">Đăng nhập ngay</a>
            </div>
        </form>
    </div>
</section>

<style>
    .login-holder {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    .bg-green {
        background-color: #28a745;
        color: white;
    }
    
    .error {
        color: #dc3545;
        display: block;
        margin-top: -8px;
        margin-bottom: 10px;
    }
    
    .success {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    
    .alert.error {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
</style>

<?php require page('includes/footer')?>