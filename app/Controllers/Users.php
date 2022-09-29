<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ImageModel;
use App\Models\ActionModel;
use App\Models\UserModel;
use App\Models\SubscribeModel;

class Users extends BaseController
{
    protected $userModel;
    protected $imageModel;
    protected $actionModel;
    protected $subscribeModel;

    public function __construct() 
    {
        $this->userModel = new UserModel();
        $this->imageModel = new ImageModel();
        $this->actionModel = new ActionModel();
        $this->subscribeModel = new SubscribeModel();

    }

    public function login()
    {
        $validation = \Config\Services::validation();
        $db = db_connect();

        // Set session variable
        $session = session();

        if ($this->request->getMethod() === 'post' && ! empty($_POST)) {   
            $validation->getRuleGroup('login');
            $validation->setRuleGroup('login');
            $validation->withRequest($this->request)->run(); 

            $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));

            $secret = env('RECAPTCHAV2_secretkey');

            $credential = [
                'secret'    => $secret,
                'response'  => $recaptchaResponse,
            ];

            $verify = curl_init();

            curl_setopt($verify, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($verify, CURLOPT_POST, TRUE);
            curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
            curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($verify, CURLOPT_RETURNTRANSFER, TRUE);

            $response = curl_exec($verify);

            $status = json_decode($response, TRUE);

            curl_close($verify);

            if (empty($validation->getErrors()) && $status['success']) {

                $login = [
                    'username'  => $db->escapeString($this->request->getVar('username')),
                    'password'  => $db->escapeString($this->request->getVar('password')),
                ];

                $user = $this->userModel->getUser($login['username']);

                if (! empty($user)) {

                    // Storing session values
                    $this->setUserSession($user);

                    // Storing success message
                    session()->setFlashdata('success', 'You have successfully logged in!');

                    // Update last login datetime
                    $this->userModel->lastLogin(session()->get('id'));

                    // Redirecting to dashboard after login
                    if ($user->role == 1) {

                        return redirect('admin_dashboard');
                    
                    } elseif ($user->role == 0) {

                        return redirect('member_dashboard');
                    }
                }
                
            } else {

                $data = [
                    'title'     => 'Login',
                    'errors'    => $validation->getErrors(),
                ];

                echo view('templates/index_header', $data);
                echo view('users/login');
                echo view('templates/footer', $data);
            }   
        } else {
            $data = [
                'title'     => 'Login',
                'scripts'   => [
                    'js/captcha',
                ],   
            ];

                echo view('templates/index_header', $data);
                echo view('users/login');
                echo view('templates/footer', $data);  
        }
    }

    /**
     * Sets session with user id, username, isLoggedIn, and role for use in member/admin site
     * @param model user data
     * @return boole if session was set successfully
     */
    private function setUserSession($user)
    {
        $data = [
            'id' => $user->id,
            'username' => $user->username,
            'profile_image' => $user->profile_image,
            'isLoggedIn' => true,
            'role' => $user->role,
        ];

        session()->set($data);
            
    }

    public function register() 
    {
        $validation = \Config\Services::validation();
        $db = db_connect();

        if ($this->request->getMethod() == 'post' && ! empty($_POST)) {

            $validation->getRuleGroup('registration');
            $validation->setRuleGroup('registration');
            $validation->withRequest($this->request)->run(); 

            $bday_year = $this->request->getPost('bday_year');
            $bday_month = $this->request->getPost('bday_month');
            $bday_day = $this->request->getPost('bday_day');

            $validation->getRuleGroup('date');
            $validation->setRuleGroup('date');
            $validation->run(['bday_month' => $bday_month, 'bday_day' => $bday_day, 'bday_year' => $bday_year], 'date');

            if (empty($validation->getErrors())) {

                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');
                $aboutMe = $this->request->getPost('about_me');
                $bday_month = $this->userModel->escapeString($this->request->getVar('bday_month'));
                $bday_day = $this->userModel->escapeString($this->request->getVar('bday_day'));
                $bday_year = $this->userModel->escapeString($this->request->getVar('bday_year'));
                $gender = $this->request->getPost('gender');
                $occupation = $this->request->getPost('occupation');
                $hometown = $this->request->getPost('hometown');
                $country = $this->request->getPost('country');
                $fav_shape = $this->request->getPost('fav_shape');
                $fav_color = $this->request->getPost('fav_color');

                $newUser = [
                    'username'      => $db->escapeString($username),
                    'password'      => $db->escapeString($password),
                    'about_me'      => (!empty($aboutMe)) ? $db->escapeString($aboutMe) : NULL,
                    'bday_month'      => (!empty($bday_month)) ? $db->escapeString($bday_month) : NULL,
                    'bday_day'      => (!empty($bday_day)) ? $db->escapeString($bday_day) : NULL,
                    'bday_year'      => (!empty($bday_year)) ? $db->escapeString($bday_year) : NULL,
                    'gender'        => (!empty($gender)) ? $gender : NULL,
                    'occupation'    => (!empty($occupation)) ? $db->escapeString($occupation) : NULL,
                    'hometown'      => (!empty($hometown)) ? $db->escapeString($hometown) : NULL,
                    'country'       => (!empty($country)) ? $db->escapeString($country) : NULL,
                    'fav_shape'     => (!empty($fav_shape)) ? $fav_shape : NULL,
                    'fav_color'     => (!empty($fav_color)) ? $fav_color : NULL,
                    'modified'      => NULL,
                ];

                if ($this->userModel->addUser($newUser)) {

                    session()->setFlashdata('success', 'Successful Registration');

                    $data['title'] = 'Login';

                    echo view('templates/index_header', $data);
                    echo view('users/login');
                    echo view('templates/footer', $data);

                } else {

                    session()->setFlashdata('error', 'Something went wrong with your registration! Please try again.');
                }

            } else {

                $data = [];

                $data = [
                    'title'     => 'Register',
                    'script'    => 'js/click_link',
                    'errors'    => $validation->getErrors(),
                ];
                
                echo view('templates/index_header', $data);
                echo view('users/register', $data);
                echo view('templates/footer', $data);
            }
        } else {
            $data = [
                'title'         => 'Register',
                'scripts'        => [
                    'js/click_link'
                ],
            ];
        
            echo view('templates/index_header', $data);
            echo view('users/register', $data);
            echo view('templates/footer', $data);
        }
    }

    public function edit_profile() 
    {
        $validation = \Config\Services::validation();
        $db = db_connect();

        if ($this->request->getMethod() == 'post' && ! empty($_POST)) {

            $validation->getRuleGroup('profile');
            $validation->setRuleGroup('profile');
            $validation->withRequest($this->request)->run(); 

            $bday_year = $this->request->getPost('bday_year');
            $bday_month = $this->request->getPost('bday_month');
            $bday_day = $this->request->getPost('bday_day');

            $validation->getRuleGroup('date');
            $validation->setRuleGroup('date');
            $validation->run(['bday_month' => $bday_month, 'bday_day' => $bday_day, 'bday_year' => $bday_year], 'date');

            if (empty($validation->getErrors())) {

                $editProfile = [];

                $aboutMe = $this->request->getPost('about_me');
                $bday_month = $this->userModel->escapeString($this->request->getVar('bday_month'));
                $bday_day = $this->userModel->escapeString($this->request->getVar('bday_day'));
                $bday_year = $this->userModel->escapeString($this->request->getVar('bday_year'));
                $gender = $this->request->getPost('gender');
                $occupation = $this->request->getPost('occupation');
                $hometown = $this->request->getPost('hometown');
                $country = $this->request->getPost('country');
                $fav_shape = $this->request->getPost('fav_shape');
                $fav_color = $this->request->getPost('fav_color');

                $editProfile = [
                    'about_me'      => (!empty($aboutMe)) ? $db->escapeString($aboutMe) : NULL,
                    'bday_month'      => (!empty($bday_month)) ? $db->escapeString($bday_month) : NULL,
                    'bday_day'      => (!empty($bday_day)) ? $db->escapeString($bday_day) : NULL,
                    'bday_year'      => (!empty($bday_year)) ? $db->escapeString($bday_year) : NULL,
                    'gender'        => (!empty($gender)) ? $gender : NULL,
                    'occupation'    => (!empty($occupation)) ? $db->escapeString($occupation) : NULL,
                    'hometown'      => (!empty($hometown)) ? $db->escapeString($hometown) : NULL,
                    'country'       => (!empty($country)) ? $db->escapeString($country) : NULL,
                    'fav_shape'     => (!empty($fav_shape)) ? $fav_shape : NULL,
                    'fav_color'     => (!empty($fav_color)) ? $fav_color : NULL,
                    'modified'      => NULL,
                ];

                if ($this->userModel->updateProfile($editProfile)) {

                    session()->setFlashdata('success', 'Your profile has been updated successfully.');

                    return redirect()->route('member_profile', [session()->get('username')]);

                } else {

                    session()->setFlashdata('error', 'Something went wrong while editing your profile! Please try again.');
                }
            } else {
                
                $data = [
                    'title'     => 'Edit Profile',
                    'errors'    => $validation->getErrors(),
                ];

                echo view('templates/header', $data);
                echo view('templates/navigation', $data);
                echo view('users/members/edit_profile', $data);
                echo view('templates/footer', $data);
            }
        } else {

            $data = [];

            $data = [
                'title'     => 'Edit Profile',
                'profile'   => $this->userModel->fillUserEntity(session()->get('username')),
            ];

            echo view('templates/header', $data);
            echo view('templates/navigation', $data);
            echo view('users/members/edit_profile', $data);
            echo view('templates/footer', $data);
        }
    }

    public function profile_image()
    {
        if ($this->request->getMethod() == 'post' && $this->request->getFile('image')->isValid()) {

            $validation = \Config\Services::validation();

            $imageFile = $this->request->getFile('image');

            // Validate image file separately as it doesn't get stored in the database
            $validation->getRuleGroup('image');
            $validation->setRuleGroup('image');
            $validation->run(['image' => $imageFile], 'image');

            if (empty($validation->getErrors())) {    

                $oldFile = $this->userModel->getUser(session()->get('username'));
            

                // Get random file name
                $newFilename = $imageFile->getRandomName();

                $data = [];

                $data = [
                    'profile_image'     => $newFilename,
                    'modified'          => NULL,
                ];

                if ($this->userModel->updateProfileImage($data)) {

                    // Store file in public_html/assets/img/uploads/ folder
                    if ($imageFile->move('./assets/img/profile/', $newFilename)) {

                        if ($oldFile->profile_image !== 'default-profile.jpg') {
                            unlink('./assets/img/profile/' . $oldFile->profile_image);
                        }

                        session()->setFlashdata('success', 'Your image was successfully uploaded');

                        session()->remove('profile_image');
                        session()->set(['profile_image' => $newFilename]);

                        return redirect()->route('member_profile', [session()->get('username')]);
                    }
                
                } else {

                    session()->setFlashdata('error', 'There was an error saving your profile image. Please try again.');

                    return redirect()->route('member_profile', [session()->get('username')]);
                }

            } else {
                $data = [
                    'title'     => 'Upload Profile Image',
                    'errors'    => $validation->getErrors(),
                ];

                echo view('templates/header', $data);
                echo view('templates/navigation', $data);
                echo view('users/members/upload_profile_image', $data);
                echo view('templates/footer', $data);
            }

        } else {
            $data = [
                'title'     => 'Upload Profile Image',
                'scripts'    => [
                    'js/image_preview',
                ],
            ];

        echo view('templates/header', $data);
        echo view('templates/navigation', $data);
        echo view('users/members/upload_profile_image', $data);
        echo view('templates/footer', $data);
        }
    }

    /**
     * Logout user and redirect to Login page
     */
    public function logout()
    {
        session()->destroy();
        return redirect('login');
    }
}