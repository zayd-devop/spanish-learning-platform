<?php

namespace App\Http\Controllers;

use App\Models\Licence;
use Illuminate\Http\Request;

class LicenceController extends Controller
{
    public function index()
    {
        $licences = Licence::all();
        return response()->json($licences);
    }
}
