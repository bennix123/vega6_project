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
    
        if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
            $profilePhotoData = file_get_contents($_FILES['profilePhoto']['tmp_name']);
        } else {
            $profilePhotoData = null;
        }

            $data = [
                'name' => $request->getPost('name'),
                'email' => $request->getPost('email'),
                'password' => password_hash($request->getPost('password'), PASSWORD_DEFAULT),
                'profile_photo' => $profilePhotoData, // Store the binary data in the column
            ];
    
            try {
                $this->userModel->insert($data);
            } catch (\Exception $e) {
                $status = false;
                $message = $e->getMessage();
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
    
        if (empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Email and password are required');
        }
    
        $user = $userModel->where('email', $email)->first();
    
    
        if (!$user) {
            return redirect()->to('public/login')->with('error', 'User not found');
        }
    

        if (password_verify($password, $user['password'])) {
    
            $session = session();
            $session->set('user', $user);
            // $_SESSION['user'] = $user;
            return redirect()->to('public/dashboard');
        } else {
            // Authentication failed, show an error message
            return redirect()->to('public/login')->with('error', 'Invalid email or password');
        }
    }
    

    public function dashboard()
    {
        // Check if the user is authenticated
        $session = session();
        $user = $session->get('user');
        $this->updateSession($user['id']);
    
        if (!$user) {
            return redirect()->to('public/login');
        }
        $user['profile_photo'] = base64_encode($user['profile_photo']);
    
        // Load the dashboard view with user information
        return view('dashboard', ['user' => $user]);
    }

    private function updateSession($userId)
{
    $userModel = new UserModel(); // Replace with your actual user model
    $latestUserData = $userModel->getUserById($userId); // Fetch the latest user data

    // Update the session data with the latest user data
    $session = session();
    $session->set('user', $latestUserData);
}

    public function profile_details()
    {
        // Check if the user is authenticated
        $session = session();
        $user = $session->get('user');
    
        if (!$user) {
            return redirect()->to('public/login');
        }
    
        // Load the dashboard view with user information
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

    // Validate and update user data
    $validationRules = [
        'name' => 'required',
        'email' => 'required|valid_email',
    ];

    if ($this->request->getPost('new_password')) {
        // If a new password is provided, add validation rules
        $validationRules['new_password'] = 'required|min_length[8]';
        $validationRules['confirm_password'] = 'required|matches[new_password]';
    }

    if (!$this->validate($validationRules)) {
        // Validation failed, return to the profile page with errors
        return redirect()->to('public/profile')->withInput()->with('validation', $this->validator);
    }

    // Update user data
    $userModel->update($user['id'], [
        'name' => $postData['name'],
        'email' => $postData['email'],
    ]);

    if ($this->request->getPost('new_password')) {
        // If a new password is provided, update the password
        $hashedPassword = password_hash($postData['new_password'], PASSWORD_DEFAULT);
        $userModel->update($user['id'], ['password' => $hashedPassword]);
    }

    // Handle profile picture upload
    $profilePicture = $this->request->getFile('profile_picture');
    if ($profilePicture->isValid() && !$profilePicture->hasMoved()) {
        // Store the profile picture with a unique name
        $newName = $profilePicture->getRandomName();
        $profilePicture->move(ROOTPATH . 'public/uploads/profile_pictures', $newName);
    
        // Check if the new profile picture name is different from the current value
        if ($newName !== $user['profile_photo']) {
            // Update the user's profile picture path in the database
            $userModel->update($user['id'], ['profile_photo' => $newName]);
        }
    }
    

    // Redirect back to the profile page with a success message
    return redirect()->to('public/profile')->with('success', 'Profile updated successfully');
}

// public function search()
// {
//     return view('results');
// }


// public function fetch_result()
// {
//     // Get the search query from the URL
//     $query = $this->request->getPost('query');

//     // Fetch data from Pixabay API using cURL (replace with your API key)
//     // $apiKey = 'YOUR_PIXABAY_API_KEY'; // Replace with your actual API key
//     $apiKey = '39475677-e9aabe84e2a630f7707757061';
//     $url = "https://pixabay.com/api/?key=$apiKey&q=$query&image_type=photo";

//     // Initialize cURL session
//     $ch = curl_init();

//     // Set cURL options
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     // Execute cURL session and store the response
//     $response = curl_exec($ch);

//     // Check for cURL errors
//     if (curl_errno($ch)) {
//         // Handle cURL error
//         echo 'cURL Error: ' . curl_error($ch);
//     }

//     // Close cURL session
//     curl_close($ch);

//     // Decode the JSON response
//     $data['results'] = json_decode($response);

//     // print_r($data);
//     // die;

//     // Load the results view
//     return view('results', [$data]);
// }

public function fetch_result()
{
    // Initialize data array
    $data = [];

    // Check if the form is submitted
    if ($this->request->getPost()) {
        // Get the search query from the form
        $query = $this->request->getPost('query');

        // Fetch data from Pixabay API (replace with your API key and search logic)
        $apiKey = '39475677-e9aabe84e2a630f7707757061'; // Replace with your actual API key
        $url = "https://pixabay.com/api/?key=$apiKey&q=$query&image_type=photo";

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
        $data['results'] = json_decode($response);

        // Set the search query for displaying in the view
        $data['query'] = $query;
    }

    // Load the search_view.php with the data
    return view('results', $data);
}


    


}
