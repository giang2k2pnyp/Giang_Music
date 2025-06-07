<?php 

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{

		$errors = [];
 		
 		$values = [];
 		$values['email'] = trim($_POST['email']);
 		$query = "select * from users where email = :email limit 1";
 		$row = db_query_one($query,$values);

		if(!empty($row))
		{
  			if(password_verify($_POST['password'], $row['password']))
  			{

  				authenticate($row);
				message("Đăng nhập thành công!");
				// Nếu có đường dẫn redirect thì quay về đó, ngược lại quay về home
				$redirect_url = $_GET['redirect'] ?? 'home';

				if (preg_match("/^https?:\/\//i", $redirect_url)) {
                // Chỉ cho phép redirect đến các domain trong danh sách an toàn
                $allowed_domains = [parse_url(ROOT, PHP_URL_HOST)];
                $redirect_host = parse_url($redirect_url, PHP_URL_HOST);
                
                if (in_array($redirect_host, $allowed_domains)) {
                    redirect($redirect_url);
                } else {
                    redirect('home');
                }
            } else {
                redirect($redirect_url);
            }
				exit;			
  			}
		}

		message("Email hoặc mật khẩu không chính xác", 'error'); 
	}

?>

<?php require page('includes/header')?>

<section class="content">
    <div class="login-container">
        <div class="login-card">
            <?php if(message()):?>
                <div class="alert <?= (strpos(message(), 'thành công') !== false) ? 'success' : 'error' ?>">
                    <?= message('', true) ?>
                </div>
            <?php endif;?>

            <form method="post" class="login-form">
                <div class="logo-container">
                    <img src="assets/images/logo.jpg" class="logo-img">
                </div>
                
                <h2 class="login-title">Đăng nhập</h2>
                
                <!-- Trường email -->
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                        <input value="<?= set_value('email') ?>" 
                            class="form-input" 
                            type="email" 
                            name="email" 
                            placeholder="Nhập email của bạn"
                            required>
                    </div>
                </div>
                
                <!-- Trường mật khẩu -->
                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input class="form-input" 
                            type="password" 
                            name="password" 
                            placeholder="Nhập mật khẩu"
                            required>
                    </div>
                </div>
                
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                    </label>
                    <a href="#" class="forgot-password">Quên mật khẩu?</a>
                </div>
                
                <button class="login-button">Đăng nhập</button>
                
                <div class="signup-link">
                    Bạn chưa có tài khoản? <a href="<?= ROOT ?>/signup">Đăng ký ngay</a>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
    /* .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    } */
    
    .login-card {
        width: 100%;
        max-width: 450px;
		margin: 75px auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }
    
    .logo-container {
        text-align: center;
        padding: 30px 0 20px;
    }
    
    .logo-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .login-form {
        padding: 0 40px 40px;
    }
    
    .login-title {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-weight: 600;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
    }
    
    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .input-icon {
        position: absolute;
        left: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #777;
    }
    
    .form-input {
        width: 100%;
        padding: 15px 15px 15px 45px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s;
        background-color: #f9f9f9;
        height: 50px;
        box-sizing: border-box;
    }

    .form-input {
        height: 50px;
        line-height: 1.5;
    }
    
    .form-input:focus {
        border-color: #4d90fe;
        box-shadow: 0 0 0 2px rgba(77, 144, 254, 0.2);
        outline: none;
        background-color: #fff;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
    }
    
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
        color: #555;
        font-size: 14px;
    }
    
    .remember-me input {
        margin-right: 8px;
    }
    
    .forgot-password {
        color: #4d90fe;
        font-size: 14px;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .forgot-password:hover {
        color: #357ae8;
        text-decoration: underline;
    }
    
    .login-button {
        width: 100%;
        padding: 15px;
        background: linear-gradient(to right, #4d90fe, #357ae8);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(77, 144, 254, 0.3);
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .login-button:hover {
        background: linear-gradient(to right, #357ae8, #2a65d0);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(77, 144, 254, 0.4);
    }
    
    .signup-link {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        color: #666;
        font-size: 15px;
    }
    
    .signup-link a {
        color: #4d90fe;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    
    .signup-link a:hover {
        color: #357ae8;
        text-decoration: underline;
    }
    
    .alert.success {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
        margin: 20px 40px 0;
        text-align: center;
        font-weight: 500;
    }
    
    .alert.error {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 8px;
        margin: 20px 40px 0;
        text-align: center;
        font-weight: 500;
    }
</style>

<?php require page('includes/footer')?>