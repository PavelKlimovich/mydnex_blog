<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return $this->render('admin/dashboard.twig');
    }
}