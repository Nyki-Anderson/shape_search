<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ImageModel;
use App\Models\ActionModel;
use App\Models\UserModel;
use App\Models\SubscribeModel;
use App\Models\ProfileModel;
use App\Models\AlbumModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $imageModel;
    protected $actionModel;
    protected $subscribeModel;
    protected $profileModel;
    protected $albumModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->imageModel = new ImageModel();
        $this->actionModel = new ActionModel();
        $this->subscribeModel = new SubscribeModel();
        $this->profileModel = new ProfileModel();
        $this->albumModel = new AlbumModel();

        if (session()->get('role') != 0) {

            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];

        echo view('templates/header', $data);
        echo view('templates/navigation', $data);
        echo view('users/members/dashboard', $data);
        echo view('templates/footer', $data);
    }

    public function feed(string $user)
    {
        $feed = new \App\Entities\Feed();
        $feed->setFeed($user);

        $data = [
            'title' => 'Feed',
            'feed'  => $feed,
        ];


        echo view('templates/header', $data);
        echo view('templates/navigation', $data);
        echo view('users/members/feed', $data);
        echo view('templates/footer', $data);

    }

    public function view_profile(string $userProfile)
    {
        if ($this->request->isAjax()) {

           if (! empty($this->request->getPost('action'))) {

                $request = [];

                if ($this->request->getPost('action') == 'view') {

                    $request = [
                        'profile'       => $userProfile,
                        'viewer'        => session()->get('username'),
                        'modified_at'   => NULL,
                    ];

                    return $this->profileModel->viewProfile($request);

                } else {

                    $request = [
                        'action'        => $this->request->getPost('action'),
                        'subscriber'    => session()->get('username'),
                        'user_profile'  => $userProfile,
                        'modified_at'   => NULL,
                    ];

                    return $this->subscribeModel->insertSubscriber($request);
                }

            }
        }
        $data = [];

        if (session()->get('username') == $userProfile) {

            $data = [
                'title'         => 'My Profile',
                'editProfile'   => TRUE,
            ];

        } else {

            $data = [
                'title'         => $userProfile . "'s Profile",
                'editProfile'   => FALSE,
            ];
        }

        $data['profile'] = $this->userModel->fillUserEntity($userProfile);
        $data['profileUploads'] = $this->imageModel->getGallery(['uploader' => $userProfile]);
        $data['profileSubscribers'] = $this->userModel->getSubscribeProfiles(['profile' => $userProfile], 'subscriber');
        $data['profileSubscriptions'] = $this->userModel->getSubscribeProfiles(['subscriber' => $userProfile], 'profile');
        $data['scripts'] = [
            'js/profile_subscribe',
            'js/profile_views'
        ];

        echo view('templates/header', $data);
        echo view('templates/navigation', $data);
        echo view('users/members/view_profile', $data);
        echo view('templates/footer', $data);
    }

    public function view_history()
    {
        $data = [
            'title'             => 'View History',
            'imageHistory'      => $this->imageModel->getUserHistory(session()->get('username')),
            'profileHistory'    => $this->profileModel->getUserHistory(session()->get('username')),
        ];

        echo view('templates/header', $data);
        echo view('templates/navigation', $data);
        echo view('users/members/history', $data);
        echo view('templates/footer', $data);
    }

    public function view_favorites()
    {
        $data = [
            'title'     => 'View Favorites',
            'favorites' => $this->imageModel->getUserFavorites(session()->get('username')),
        ];

        echo view('templates/header', $data);
        echo view('templates/navigation', $data);
        echo view('users/members/favorites', $data);
        echo view('templates/footer', $data);
    }

    public function manage_uploads()
    {
        if ($this->request->isAjax()) {

            if (! empty($this->request->getPost('album_name')) && ! empty($this->request->getPost('viewkey'))) {

                $request = [];

                $request = [
                    'album_name'    => $this->request->getPost('album_name'),
                    'owner'         => session()->get('username'),
                    'viewkey'       => $this->request->getPost('viewkey'),
                    'modified_at'   => NULL,
                ];

                return $this->albumModel->checkImageAlbum($request);
            }
        }

        $data = [];

        $data = [
            'title'         => 'Manage Uploads',
            'uploads'       => $this->imageModel->getGallery(['uploader' => session()->get('username')]),
            'albums'        => $this->albumModel->getUserAlbums(session()->get('username')),
            'scripts'       => [
                'js/upload_album',
            ],
        ];

        echo view('templates/header', $data);
        echo view('templates/navigation');
        echo view('users/members/manage_uploads', $data);
        echo view('templates/footer', $data);
    }

    public function upload_image(string $viewkey = NULL)
    {
        if ($this->request->getMethod() == 'post' && $this->request->getFile('image')->isValid()) {

            $validation = \Config\Services::validation();

            $oldFile = NULL;
            $imageFile = $this->request->getFile('image');

            // Validate image file separately as it doesn't get stored in the database
            $validation->getRuleGroup('image');
            $validation->setRuleGroup('image');
            $validation->run(['imageFile' => $imageFile], 'image');

            $title = $this->request->getVar('title');
            $tags = $this->request->getVar('tags');

            // Validate and format $title and $tag user input
            $title = strip_tags(trim($this->request->getVar('title')));

            // Format tags to comma separated without spaces or white space
            $tags = strip_tags(trim($this->request->getVar('tags')));
            $tags = strtolower($tags);
            $tags = preg_replace('/[\s,]+/', ' ', $tags);
            $tags = str_replace(' ', ',', $tags);

            $userInput = [];

            $userInput = [
                'title' => $title,
                'tags'  => $tags,
            ];

            $validation->getRuleGroup('upload');
            $validation->setRuleGroup('upload');
            $validation->run($userInput, 'upload');

            if (empty($validation->getErrors())) {

                if ($viewkey !== NULL) {

                    $oldFile = $this->imageModel->getImage(['viewkey' => $viewkey]);

                } else {

                    $viewkey = uniqid();
                }

                // Get random file name
                $newFilename = $imageFile->getRandomName();

                $data = [];

                $data = [
                    'viewkey'       => $viewkey,
                    'uploader'      => session()->get('username'),
                    'title'         => $title,
                    'tags'          => $tags,
                    'filename'      => $newFilename,
                    'modified_at'   => NULL,
                ];

                if ($this->imageModel->storeImage($data)) {

                    // Store file in public_html/assets/img/uploads/ folder
                    if ($imageFile->move('./assets/img/uploads/', $newFilename)) {

                        if (isset($oldFile) ) {

                            unlink('./assets/img/uploads/' . $oldFile->filename);

                        }

                        session()->setFlashdata('success', 'Your image was successfully uploaded');

                        return redirect()->route('manage_uploads');
                    }

                } else {

                    session()->setFlashdata('error', 'There was an error saving your image. Please try again.');

                    return redirect()->route('manage_uploads');
                }

            } else {

                 $data = [];

                $data = [
                    'title'     => 'Edit/Upload an Image',
                    'viewkey'   => $viewkey,
                    'albums'    => $this->albumModel->getUserAlbums(session()->get('username')),
                    'errors'    => $validation->getErrors(),
                    'scripts'           => [
                        'js/image_preview'
                    ],
                ];

                echo view('templates/header', $data);
                echo view('templates/navigation',$data);
                echo view('users/members/upload_image', $data);
                echo view('templates/footer', $data);
            }

        }

        if ($viewkey !== NULL) {

            $data = [];

            $uploadEdit = $this->imageModel->getImage(['viewkey' => $viewkey]);

            $tagsSpaces = preg_replace('/,/', ', ', trim($uploadEdit->tags));

            $data = [
                'title'             => 'Edit an Upload',
                'viewkey'           => $viewkey,
                'uploadTitle'       => $uploadEdit->title,
                'uploadTags'        => $tagsSpaces,
                'uploadFilename'    => $uploadEdit->filename,
                'scripts'           => [
                    'js/image_preview'
                ],
        ];

        } else {

            $data = [];

            $data = [
                'title'     => 'Upload an Image',
                'viewkey'   => $viewkey,
                'scripts'   => [
                        'js/image_preview'
                    ],
            ];
        }

        echo view('templates/header', $data);
        echo view('templates/navigation');
        echo view('users/members/upload_image', $data);
        echo view('templates/footer', $data);
    }

    public function delete_upload(string $viewkey)
    {
        $imageDelete = $this->imageModel->getImage(['viewkey' => $viewkey]);

        if (unlink('assets/img/uploads/' . $imageDelete->filename)) {

            if ($this->imageModel->deleteImage(['viewkey' => $viewkey])) {

                session()->setFlashdata('success', 'Your image was successfully deleted.');

            } else {

                session()->setFlashdata('error', 'Something went wrong when deleting your image. Please try again.');
            }
        } else {

            session()->setFlashdata('error', 'Something went wrong when deleting your image. Please try again.');
        }
        return redirect('manage_uploads');
    }
}