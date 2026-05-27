<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $helpers = ['url', 'form', 'text'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);
    }

    protected function render(string $view, array $data = []): string
    {
        $data['userRole']   = session()->get('user_role');
        $data['userName']   = session()->get('user_name');
        $data['userAvatar'] = session()->get('user_avatar');
        return view('layouts/main', array_merge($data, ['content_view' => $view]));
    }
}
