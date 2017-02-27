<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Badge;

class BadgeController extends Controller
{
    public function listBadges() {
    	$badges = Badge::where('type', 0)->where('visible', 1)->get();
    	$certificates = Badge::where('type', 1)->where('visible', 1)->get();
    	$licenses = Badge::where('type', 2)->where('visible', 1)->get();

    	return view('badges.list')->with('badges', $badges)->with('certificates', $certificates)->with('licenses', $licenses);
    }

    public function viewBadge($id) {
    	$badge = Badge::findOrFail($id);
    	return view('badges.view')->with('badge', $badge);
    }
}
