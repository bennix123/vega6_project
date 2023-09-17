<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password', 'profile_photo'];

    public function register($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insertID();
    }
    public function getUserById($userId)
    {
        return $this->where('id', $userId)->first();
    }

    public function login($email, $password) {
        $user = $this->db->where('email', $email)->get($this->table)->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }
}

