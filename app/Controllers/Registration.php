<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class RegistrationController extends BaseController
{
    public function index()
    {
        // Load the registration form view
        return view('registration_form');
    }

    public function processRegistration()
    {
        print_r("i am here");
        die;
        // Handle the form submission here

        // Example: Retrieve POST data
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Example: Perform validation and database operations here

        // Example: Return a JSON response
        $response = [
            'status' => 'success',
            'message' => 'Registration successful!',
        ];

        return $this->response->setJSON($response);
    }
}
