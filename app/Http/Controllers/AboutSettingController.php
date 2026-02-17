<?php

namespace App\Http\Controllers;

use App\Models\AboutSetting;
use Illuminate\Http\Request;

class AboutSettingController extends Controller
{
    public function index()
    {
        $settings = AboutSetting::settings();
        return view('super-admin.about-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'who_we_are' => 'nullable|string',
            'our_vision' => 'nullable|string',
            'our_mission' => 'nullable|string',
            'what_we_believe' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_whatsapp' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
        ]);

        $settings = AboutSetting::settings();

        $settings->update([
            'who_we_are' => $request->who_we_are,
            'our_vision' => $request->our_vision,
            'our_mission' => $request->our_mission,
            'what_we_believe' => $request->what_we_believe,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_whatsapp' => $request->contact_whatsapp,
            'contact_address' => $request->contact_address,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'linkedin_url' => $request->linkedin_url,
            'instagram_url' => $request->instagram_url,
        ]);

        return redirect()->route('super-admin.about-settings.index')
            ->with('success', 'About Us settings updated successfully!');
    }

    public function show()
    {
        $settings = AboutSetting::settings();
        return view('about', compact('settings'));
    }
}
