<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() : Renderable
    {

        $section_count = DB::table('sections')->count();
        $category_count = DB::table('categories')->count();
        $admin_count = DB::table('admins')->count();
        $role_count = DB::table('roles')->count();
        $notification_count = DB::table('admin_notifications')->count();
        $content_count = DB::table('contents')->count();
        $paragraph_count = DB::table('paragraphs')->count();



        return view('admin.dashboard',compact(
            'section_count','category_count','admin_count','role_count','notification_count','content_count','paragraph_count'
        ));
    }
}
