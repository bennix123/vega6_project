<?php

namespace App\Controllers;
use App\Models\UserModel;
class Home extends BaseController
{

    protected $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }


    public static function index() {
        return view('register_user');
    }

    public function processRegistration()
    {
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $response = [
            'status' => 'success',
            'message' => 'Registration successful!',
        ];

        return $this->response->setJSON($response);
    }

    public function register_user() {

        $request = $this->request;
        $status = true;
        $message = 'Registration Successful';
    // Checking if the profile photo was uploaded otherwise set it to null
        if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
            $profilePhotoData = file_get_contents($_FILES['profilePhoto']['tmp_name']);
        } else {
            $profilePhotoData = null;
        }
    
        $email = $request->getPost('email');
    
        // Checking if the email already exists in the database
        $existingUser = $this->userModel->where('email', $email)->first();
    //if the email already exists in the database, set the status to false and show the error message
        if ($existingUser) {
            $status = false;
            $message = 'Email already exists. Please choose a different email address.';
        } else {
            // Email doesn't exist, proceed with registration
            $data = [
                'name' => $request->getPost('name'),
                'email' => $email,
                'password' => password_hash($request->getPost('password'), PASSWORD_DEFAULT),
                'profile_photo' => $profilePhotoData,
            ];
    
            try {
                $this->userModel->insert($data);
            } catch (\Exception $e) {
                $status = false;
                $message = $e->getMessage();
            }
        }
    
        return $this->response->setJSON(['status' => $status, 'message' => $message]);
    }    
    
    public function login() {
        return view('login_page');
    }
    public function authenticate()
    {
    
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
    
        $user = $userModel->where('email', $email)->first();
    
    //redirect the user to the login page if the user is not found
        if (!$user) {
            return redirect()->to('public/login')->with('error', 'User not found');
        }
    
    //redirect the user to the login page if the password is incorrect
        if (password_verify($password, $user['password'])) {
    //setting the user data in the session
            $session = session();
            $session->set('user', $user);
     //redirecting the user to the dashboard after login
            return redirect()->to('public/dashboard');
        } else {
            //redirecting the user to the login page with an error message
            return redirect()->to('public/login')->with('error', 'Invalid email or password');
        }

    }
    

    public function dashboard()
    {
        $session = session();
        $user = $session->get('user');
            //updating the session data with the latest user data
        $this->updateSession($user['id']);
        if (!$user) {
            return redirect()->to('public/login');
        }
        $user['profile_photo'] = base64_encode($user['profile_photo']);
        return view('dashboard', ['user' => $user]);
    }

    private function updateSession($userId)
{
        //updating the  data with the session  user data
    $userModel = new UserModel();
    $latestUserData = $userModel->getUserById($userId);
    $session = session();
    $session->set('user', $latestUserData);
}

    public function profile_details()
    {
        $session = session();
        $user = $session->get('user');
    
        if (!$user) {
            return redirect()->to('public/login');
        }
        return view('profile', ['user' => $user]);
    }


    public function updateProfile()
{
    $session = session();
    $user = $session->get('user');

    if (!$user) {
        return redirect()->to('public/login');
    }

    $userModel = new UserModel();
    $postData = $this->request->getPost();

    $validationRules = [
        'name' => 'required',
        'email' => 'required|valid_email',
    ];

    if ($this->request->getPost('new_password')) {
        $validationRules['new_password'] = 'required|min_length[8]';
        $validationRules['confirm_password'] = 'required|matches[new_password]';
    }
//if the validation fails, redirect the user to the profile page with the validation errors
    if (!$this->validate($validationRules)) {
        return redirect()->to('public/profile')->withInput()->with('validation', $this->validator);
    }

    $userModel->update($user['id'], [
        'name' => $postData['name'],
        'email' => $postData['email'],
    ]);

    if ($this->request->getPost('new_password')) {
        $hashedPassword = password_hash($postData['new_password'], PASSWORD_DEFAULT);
        
        // Updating the 'password' and 'modified_ts' fields
        $userModel->where('id', $user['id'])->set(['password' => $hashedPassword, 'modified_ts' => date('Y-m-d H:i:s')])->update();
    }
    
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $profilePhotoData = file_get_contents($_FILES['profile_picture']['tmp_name']);
        
        // Updating the 'profile_photo' and 'modified_ts' fields
        $userModel->where('id', $user['id'])->set(['profile_photo' => $profilePhotoData, 'modified_ts' => date('Y-m-d H:i:s')])->update();
    }    
    
    return redirect()->to('public/profile')->with('success', 'Profile updated successfully');
}


public function fetch_result()
{
    // Initialize data array
    $data = [];

    // Check if the form is submitted
    if ($this->request->getPost()) {
        // Get the search query from the form
        $query = $this->request->getPost('query');
        $to_include_video = $this->request->getPost('include_video');

        $apiKey = '39475677-e9aabe84e2a630f7707757061';
        if($to_include_video) {
            $url = "https://pixabay.com/api/videos/?key=$apiKey&q=$query";
        }else{
        $url = "https://pixabay.com/api/?key=$apiKey&q=$query&image_type=photo";
        }
        // Initialize cURL session
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Execute cURL session and store the response
        $response = curl_exec($ch);
        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle cURL error
            echo 'cURL Error: ' . curl_error($ch);
        }
        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data['results'] = json_decode($response,true);
        
        // print_r($data['results']);
        // die;
        // Set the search query for displaying in the view
        $data['query'] = $query;

    }
    return view('results', $data);
}
}
