<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private array $defaults = [
        'studio_name' => 'Kalatmaka Interior Design',
        'contact_email' => 'hello@kalatmaka.design',
        'whatsapp_number' => '+62 812 3456 7890',
        'business_hours' => 'Mon-Fri, 09:00 - 18:00',
        'address' => 'Jl. Dharmawangsa X No. 12, Kebayoran Baru, Jakarta Selatan, 12160, Indonesia',
        'whatsapp_link' => 'https://wa.me/6281234567890',
        'consult_link' => '/kontak',
        'instagram_url' => 'https://instagram.com/kalatmaka.design',
        'linkedin_url' => 'https://linkedin.com/company/kalatmaka',
        'pinterest_url' => 'https://pinterest.com/kalatmaka',
        'dark_logo_url' => '',
        'light_logo_url' => '',
        'favicon_url' => '',
        'primary_color' => '#3B2A23',
        'accent_color' => '#C6A77D',
        'background_color' => '#F5F0EA',
        'headline_font' => 'Playfair Display',
        'body_font' => 'Plus Jakarta Sans',
        'meta_title' => 'Kalatmaka Interior Design',
        'meta_description' => 'Luxury interior design and architectural surfaces.',
        'maintenance_mode' => false,
    ];

    public function index()
    {
        return response()->json($this->settings());
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->settings as $key => $value) {
            if (! array_key_exists($key, $this->defaults)) {
                continue;
            }

            AppSetting::updateOrCreate(
                ['key' => $key],
                ['value' => json_encode($value)]
            );
        }

        return response()->json($this->settings());
    }

    private function settings(): array
    {
        $stored = AppSetting::all()
            ->mapWithKeys(fn (AppSetting $setting) => [
                $setting->key => json_decode($setting->value, true),
            ])
            ->toArray();

        return array_merge($this->defaults, $stored);
    }
}
