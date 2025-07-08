<?php

declare(strict_types=1);

namespace App\Http\Controllers\Acounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index(Request $request)
    {
        // Logic to handle accounting index view
        return view('admin.pages.accounting.dashboard');
    }

    public function trials_fees(Request $request)
    {
        // Logic to handle creating a new accounting entry
        return view('admin.pages.accounting.trialsfees');
    }
}
