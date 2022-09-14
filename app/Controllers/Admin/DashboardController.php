<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Return admin page.
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->render('admin/dashboard.twig');
    }
}
