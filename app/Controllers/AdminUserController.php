<?php

/**
 * DocedFrame
 * AdminUserController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use App\Models\User;
use App\Models\Role;

class AdminUserController extends Controller
{
	public function __construct()
	{
		if (!Auth::check() || !Auth::can('manage_users')) {
			$this->redirect('/df-admin');
		}
	}
	
	public function index()
	{
		$userModel = new User();
		$users = $userModel->all();
		
		$roleModel = new Role();
		
		foreach ($users as &$user) {
			$userRoles = $roleModel->getByUserId($user['id']);
			$user['roles'] = $userRoles;
		}
		
		View::render('admin.users.index', ['users' => $users]);
	}
	
	public function create()
	{
		$roleModel = new Role();
		$roles = $roleModel->all();
		
		View::render('admin.users.create', ['roles' => $roles]);
	}
	
	public function store()
	{
		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';
		$displayName = $_POST['display_name'] ?? '';
		$roleId = $_POST['role_id'] ?? 0;
		
		$userModel = new User();
		$userId = $userModel->insert([
			'email' => $email,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'display_name' => $displayName,
			'status' => 1
		]);
		
		if ($userId && $roleId) {
			$roleModel = new Role();
			$roleModel->assignToUser($userId, $roleId);
		}
		
		$this->redirect('/df-admin/users');
	}
	
	public function edit($id)
	{
		$userModel = new User();
		$user = $userModel->find($id);
		
		$roleModel = new Role();
		$roles = $roleModel->all();
		$userRoles = $roleModel->getByUserId($id);
		
		$userRoleIds = array_column($userRoles, 'id');
		
		View::render('admin.users.edit', [
			'user' => $user,
			'roles' => $roles,
			'userRoleIds' => $userRoleIds
		]);
	}
	
	public function update($id)
	{
		$displayName = $_POST['display_name'] ?? '';
		$status = $_POST['status'] ?? 1;
		$roleId = $_POST['role_id'] ?? 0;
		
		$userModel = new User();
		$userModel->update($id, [
			'display_name' => $displayName,
			'status' => $status
		]);
		
		if (isset($_POST['password']) && !empty($_POST['password'])) {
			$userModel->update($id, [
				'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
			]);
		}
		
		$roleModel = new Role();
		$userRoles = $roleModel->getByUserId($id);
		
		foreach ($userRoles as $role) {
			$roleModel->removeFromUser($id, $role['id']);
		}
		
		if ($roleId) {
			$roleModel->assignToUser($id, $roleId);
		}
		
		$this->redirect('/df-admin/users');
	}
	
	public function delete($id)
	{
		if ($id == Auth::id()) {
			echo "Kendi hesabınızı silemezsiniz.";
			return;
		}
		
		$userModel = new User();
		$userModel->delete($id);
		
		$this->redirect('/df-admin/users');
	}
}