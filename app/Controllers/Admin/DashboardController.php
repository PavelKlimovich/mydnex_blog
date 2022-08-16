<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        session_start();

        if ($_SESSION['auth']->role == 'admin') {
            return $this->render('admin/dashboard.twig');
        }

        return $this->redirect($_ENV['APP_URL'].'/login');
    }

}