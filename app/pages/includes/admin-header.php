<!DOCTYPE html>
<html lang="en">
<head>
    <title>Giang Music</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css?52423">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-header {
            background-color: #3e344e !important;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .admin-header-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            height: 80px;
        }

        .admin-header .logo-holder {
            width: 80px;
            flex-shrink: 0;
            margin-right: 20px;
        }

        .admin-header .main-content1 {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .admin-header .main-title {
            padding: 10px 0;
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            height: 50%;
            display: flex;
            align-items: center;
        }

        .admin-header .main-nav {
            display: flex;
            height: 50%;
            align-items: flex-end;
            padding-top: 10px;
        }

        .admin-header .nav-item {
            padding: 8px 12px;
            min-width: auto;
            text-align: center;
        }

        .admin-header .nav-item > a {
            color: white !important;
            font-weight: 500;
            transition: opacity 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .admin-header .nav-item > a:hover {
            opacity: 0.8;
        }

        .admin-header .dropdown {
            position: relative;
        }

        .admin-header .dropdown-list {
            position: absolute;
            border: solid thin #555;
            background-color: #3e344e;
            margin-top: 10px;
            min-width: 160px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 100;
            display: none;
        }

        .admin-header .dropdown:hover .dropdown-list {
            display: block;
        }

        .admin-header .nav-item2 {
            padding: 10px;
            text-align: left;
        }

        .admin-header .nav-item2 a {
            color: white !important;
            display: block;
            padding: 5px 0;
        }

        .admin-header .mobile-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
            padding: 10px;
            color: white;
        }

        .badge {
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8em;
            margin-left: 5px;
            display: inline-block;
            min-width: 20px;
            text-align: center;
        }

        /* RESPONSIVE ADMIN HEADER */
        @media (max-width: 1200px) {
            .admin-header-container {
                padding: 0 15px;
            }
            
            .admin-header .nav-item {
                padding: 8px 10px;
                min-width: 70px;
                font-size: 14px;
            }
        }

        @media (max-width: 992px) {
            .admin-header-container {
                height: 80px;
                padding: 0 15px;
                flex-wrap: nowrap;
            }
            
            .admin-header .main-content1 {
                position: relative;
                display: block;
                width: 100%;
                margin-top: 0;
            }
            
            .admin-header .main-nav {
                display: none !important;
                position: absolute;
                top: 45px;
                left: 0;
                right: 0;
                background: #3e344e;
                z-index: 1000;
                box-shadow: 0 5px 10px rgba(0,0,0,0.1);
                flex-direction: row;
                padding: 0;
                height: auto;
            }
            
            .admin-header .main-content1.active .main-nav {
                display: flex !important;
                flex-wrap: wrap;
            }
            
            .admin-header .nav-item {
                width: auto;
                text-align: left;
                padding: 12px 20px;
                border-bottom: 1px solid #555;
                flex: none;
            }
            
            .admin-header .dropdown-list {
                position: static;
                box-shadow: none;
                border: none;
                display: none;
                width: 100%;
                background: #555;
            }
            
            .admin-header .dropdown.active .dropdown-list {
                display: block;
            }
            
            .admin-header .mobile-toggle {
                display: flex !important;
                font-size: 24px;
                cursor: pointer;
                padding: 5px 10px;
            }
        }

        @media (max-width: 768px) {
            .admin-header-container {
                height: 100px;
                padding: 0 10px;
            }
            
            .admin-header .main-nav {
                top: 100px;
                flex-direction: column;
            }
            
            .admin-header .nav-item {
                width: 100%;
            }
            
            .admin-header .mobile-toggle {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-header-container">
            <div class="logo-holder">
                <a href="<?=ROOT?>"><img class="logo" src="<?=ROOT?>/assets/images/logo.jpg"></a>
            </div>
            
            <div class="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div>

            <div class="main-content1">
                <div class="main-title">
                    ADMIN AREA
                </div>
                <div class="main-nav">
                    <div class="nav-item"><a href="<?=ROOT?>/admin">Dashboard</a></div>
                    <div class="nav-item"><a href="<?=ROOT?>/admin/users">Users</a></div>
                    <div class="nav-item"><a href="<?=ROOT?>/admin/songs">Songs</a></div>
                    <div class="nav-item"><a href="<?=ROOT?>/admin/categories">Categories</a></div>
                    <div class="nav-item"><a href="<?=ROOT?>/admin/artists">Artists</a></div>
                    <div class="nav-item"><a href="<?=ROOT?>/admin/playlist">Playlist</a></div>

                    <?php
                    $unread_count = 0;
                    if (user('role') == 'admin') {
                        $query = "SELECT COUNT(*) as count FROM threads WHERE is_read = 0";
                        $result = db_query($query);
                        $unread_count = $result[0]['count'] ?? 0;
                    }
                    ?>

                    <div class="nav-item dropdown">
                        <a href="#">Hi, <?=user('username')?>
                            <?php if ($unread_count > 0): ?>
                                <span class="badge"><?=$unread_count?></span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-list">
                            <div class="nav-item"><a href="<?=ROOT?>/admin/users/edit/<?=user('id')?>">Profile</a></div>
                            <div class="nav-item"><a href="<?=ROOT?>">Website</a></div>
                            <?php if (user('role') == 'admin'): ?>
                                <div class="nav-item">
                                    <a href="<?=ROOT?>/admin/messages">
                                        Messages
                                        <?php if ($unread_count > 0): ?>
                                            <span class="badge"><?=$unread_count?></span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="nav-item"><a href="<?=ROOT?>/logout">Logout</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.querySelector('.admin-header .mobile-toggle');
        const mainContent = document.querySelector('.admin-header .main-content1');
        const dropdowns = document.querySelectorAll('.admin-header .dropdown');
        
        // Toggle mobile menu
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                mainContent.classList.toggle('active');
            });
        }
        
        // Handle dropdowns on mobile
        if (dropdowns.length > 0) {
            dropdowns.forEach(dropdown => {
                const dropdownLink = dropdown.querySelector('a');
                
                dropdownLink.addEventListener('click', function(e) {
                    if (window.innerWidth <= 992) {
                        e.preventDefault();
                        dropdown.classList.toggle('active');
                        
                        // Close other dropdowns
                        dropdowns.forEach(other => {
                            if (other !== dropdown) {
                                other.classList.remove('active');
                            }
                        });
                    }
                });
            });
        }
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 992 && 
                !e.target.closest('.admin-header .main-content1') && 
                !e.target.closest('.admin-header .mobile-toggle')) {
                mainContent.classList.remove('active');
                
                // Close all dropdowns
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });
        
        // Close menu when clicking on a link
        const navLinks = document.querySelectorAll('.admin-header .main-nav a');
        if (navLinks.length > 0) {
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        mainContent.classList.remove('active');
                    }
                });
            });
        }
    });
    </script>

    <?php if(message()):?>
        <div class="alert"><?=message('',true)?></div>
    <?php endif;?>