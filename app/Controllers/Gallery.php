<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActionModel;
use App\Models\ImageModel;
use App\Models\CommentModel;
use App\Models\SubscribeModel;
use CodeIgniter\Time; 

class Gallery extends BaseController
{
    protected $imageModel;
    protected $actionModel;
    protected $commentModel;
    protected $subscribeModel;

    public function __construct() 
    {
        $this->imageModel = new ImageModel();
        $this->actionModel = new ActionModel();
        $this->commentModel = new CommentModel();
        $this->subscribeModel = new SubscribeModel();

        if (session()->get('role') != 0) {

            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        $data = [];
        
        $data = [
            'title'         => 'Image Gallery',
            'gallery'       => $this->imageModel->getEntireGallery(),
        ];

        echo view('templates/header', $data);
        echo view('templates/navigation');
        echo view('templates/filter_bar', $data);
        echo view('images/gallery', $data);
        echo view('templates/footer', $data);
    }

    public function view_image(string $viewkey) 
    {
        $validation = \Config\Services::validation();
        $db = db_connect();

        if ($this->request->isAjax()) {

            if (! empty($this->request->getPost('action')) && ! empty($this->request->getPost('viewkey'))) {

                $request = [];

                $request = [
                    'action'    => $this->request->getPost('action'),
                    'username' => session()->get('username'),
                    'viewkey'   => $this->request->getPost('viewkey'),
                    'modified_at'  => NULL,
                ];

                return $this->actionModel->insertAction($request);
            } 
            
            if (! empty($this->request->getPost('action')) && ! empty($this->request->getPost('user_profile'))) {

                $request = [];

                $request = [
                    'action'        => $this->request->getPost('action'),
                    'subscriber'    => session()->get('username'),
                    'user_profile'  => $this->request->getPost('user_profile'),
                    'modified_at'      => NULL,
                ];

                return $this->subscribeModel->insertSubscriber($request);
            }

            if (! empty($this->request->getPost('comment_text'))) {

                $validation->getRuleGroup('comments');
                $validation->setRuleGroup('comments');
                $validation->withRequest($this->request)->run();

                if (empty($validation->getErrors())) {

                    $request = [];

                    $request = [
                        'viewkey'           => $viewkey,
                        'comment_text'      => $this->request->getPost('comment_text'),
                        'commenter'         => $this->request->getPost('commenter'),
                        'parent_id'         => $this->request->getPost('parent_id'),
                        'comment_modified'  => NULL,
                    ];

                    if ($this->commentModel->addComment($request)) {

                        return $this->commentModel->getLastComment();
                    }
                }
            }
        } 

        $image = $this->imageModel->fillImageEntity($viewkey);

        $data = [];

        $data = [
            'image'         => $image,
            'title'         => $image->title,
            'comments'      => $this->commentModel->getComments($viewkey),
            'scripts'       => [
                'js/image_action',
                'js/image_subscribe',
                'js/image_comments',
            ],
        ];

        echo view('templates/header', $data);
        echo view('templates/navigation', $data);
        echo view('images/view_image', $data);
        echo view('templates/footer', $data);
    }
}