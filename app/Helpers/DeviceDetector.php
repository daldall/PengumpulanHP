<?php

namespace App\Helpers;

class DeviceDetector
{
    public static function detect($userAgent)
    {
        $device = 'Unknown';
        $browser = 'Unknown';

        // Deteksi Device/OS
        if (preg_match('/iPhone/i', $userAgent)) {
            $device = 'iPhone';
        } elseif (preg_match('/iPad/i', $userAgent)) {
            $device = 'iPad';
        } elseif (preg_match('/Android/i', $userAgent)) {
            if (preg_match('/Mobile/i', $userAgent)) {
                $device = 'Android Phone';
            } else {
                $device = 'Android Tablet';
            }
        } elseif (preg_match('/Windows Phone/i', $userAgent)) {
            $device = 'Windows Phone';
        } elseif (preg_match('/Windows/i', $userAgent)) {
            $device = 'Windows PC';
        } elseif (preg_match('/Macintosh/i', $userAgent)) {
            $device = 'Mac';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $device = 'Linux';
        }

        // Deteksi Browser
        if (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edge/i', $userAgent) && !preg_match('/OPR/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Microsoft Edge';
        } elseif (preg_match('/OPR/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/brave/i', $userAgent)) {
            $browser = 'Brave';
        }

        return [
            'device' => $device,
            'browser' => $browser
        ];
    }

    public static function getIcon($device)
    {
        $icons = [
            'iPhone' => 'fab fa-apple',
            'iPad' => 'fab fa-apple',
            'Android Phone' => 'fab fa-android',
            'Android Tablet' => 'fab fa-android',
            'Windows Phone' => 'fab fa-windows',
            'Windows PC' => 'fab fa-windows',
            'Mac' => 'fab fa-apple',
            'Linux' => 'fab fa-linux',
        ];

        return $icons[$device] ?? 'fas fa-desktop';
    }

    public static function getBrowserIcon($browser)
    {
        $icons = [
            'Chrome' => 'fab fa-chrome',
            'Firefox' => 'fab fa-firefox',
            'Safari' => 'fab fa-safari',
            'Microsoft Edge' => 'fab fa-edge',
            'Opera' => 'fab fa-opera',
            'Brave' => 'fas fa-shield-alt',
        ];

        return $icons[$browser] ?? 'fas fa-globe';
    }
}
