<?php

namespace App\Http\Controllers;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function Audit()
    {
        return view('admin.pages.systemsetting.usermanage.audittrail');
    }

}
