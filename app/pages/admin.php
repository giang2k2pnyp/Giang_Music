<?php 

if(!is_admin())
{
	message("only admins can access the admin page");
	redirect('login');
}

	$section 	= $URL[1] ?? "dashboard";
	$action 	= $URL[2] ?? null;
	$id 		= $URL[3] ?? null;

$allow_user_access = ($section === 'users' && $action === 'edit' && $id == user('id'));

if(!is_admin() && !$allow_user_access) {
    message("Only admins can access the admin page");
    redirect('login');
}

	switch ($section) {
		case 'dashboard':
			require page('admin/dashboard');
			break;

		case 'users':
			require page('admin/users');
			break;

		case 'categories':
			require page('admin/categories');
			break;

		case 'artists':
			require page('admin/artists');
			break;

		case 'songs':
			require page('admin/songs');
			break;
		
		case 'playlist':
			require page('admin/playlist');
			break;
		
		case 'messages':
			require page('admin/messages');
			break;
		
		case 'reply':
			require page('admin/reply	');
			break;
		
		default:
			require page('admin/404');
			break;
	}
