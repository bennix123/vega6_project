<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password', 'profile_photo'];

    public function register($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insertID(); // Return the inserted user's ID
    }
    public function getUserById($userId)
    {
        // Implement your database query here to fetch user data by ID
        return $this->where('id', $userId)->first();
    }

    public function login($email, $password) {
        // Check if email and password match in the database
        $user = $this->db->where('email', $email)->get($this->table)->row();

        if ($user && password_verify($password, $user->password)) {
            return $user; // Return the user object if login is successful
        }

        return false; // Return false if login fails
    }

    // Add other necessary functions here
}

// app/Models/UserModel.php

// namespace App\Models;

// use CodeIgniter\Model;

// class UserModel extends Model
// {
//     protected $table = 'users'; // Replace 'users' with your actual database table name
//     protected $primaryKey = 'id'; // Replace 'id' with your primary key column name if different

//     protected $allowedFields = ['name', 'email', 'password', 'profile_photo']; // Define the fields that can be inserted/updated

//     // Optionally, define validation rules for the model's fields
//     protected $validationRules = [
//         'name' => 'required|min_length[3]|max_length[50]',
//         'email' => 'required|valid_email|is_unique[users.email]', // Assuming unique email addresses
//         'password' => 'required|min_length[6]',
//     ];

//     protected $validationMessages = [
//         'email' => [
//             'is_unique' => 'The email address is already taken.',
//         ],
//     ];

//     protected $skipValidation = false;

//     // Optionally, you can define other model methods here for querying or working with user data.
// }

