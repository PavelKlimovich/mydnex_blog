<?php

namespace App\Controllers\Admin;

use Src\View\View;

class DashboardController
{
    /**
     * Return admin page.
     *
     * @return void
     */
    public function index(): void
    {
        View::get('admin/dashboard.twig');
    }
}
