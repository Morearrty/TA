<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $member = $user->member;

        return view('member.dashboard', compact('user', 'member'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        $member = $user->member;

        return view('member.profile', compact('user', 'member'));
    }

    public function downloadKta()
    {
        $user = Auth::user();
        $member = $user->member;

        return redirect()->route('anggota.download-kta', $member->id);
    }
}
