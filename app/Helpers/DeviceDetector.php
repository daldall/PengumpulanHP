<?php

namespace App\Helpers;

class DeviceDetector
{
    public static function detect($userAgent)
    {
        $device = 'Unknown';
        $browser = 'Unknown';

        // Deteksi Device/OS dengan model spesifik
        if (preg_match('/iPhone/i', $userAgent)) {
            $device = self::detectiPhoneModel($userAgent);
        } elseif (preg_match('/iPad/i', $userAgent)) {
            $device = self::detectiPadModel($userAgent);
        } elseif (preg_match('/Android/i', $userAgent)) {
            $device = self::detectAndroidModel($userAgent);
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

    private static function detectiPhoneModel($userAgent)
    {
        // iPhone models berdasarkan User-Agent
        $models = [
            '/iPhone15,2/' => 'iPhone 14 Pro',
            '/iPhone15,3/' => 'iPhone 14 Pro Max',
            '/iPhone14,7/' => 'iPhone 14',
            '/iPhone14,8/' => 'iPhone 14 Plus',
            '/iPhone14,2/' => 'iPhone 13 Pro',
            '/iPhone14,3/' => 'iPhone 13 Pro Max',
            '/iPhone14,5/' => 'iPhone 13',
            '/iPhone14,4/' => 'iPhone 13 mini',
            '/iPhone13,1/' => 'iPhone 12 mini',
            '/iPhone13,2/' => 'iPhone 12',
            '/iPhone13,3/' => 'iPhone 12 Pro',
            '/iPhone13,4/' => 'iPhone 12 Pro Max',
            '/iPhone12,1/' => 'iPhone 11',
            '/iPhone12,3/' => 'iPhone 11 Pro',
            '/iPhone12,5/' => 'iPhone 11 Pro Max',
            '/iPhone12,8/' => 'iPhone SE (2nd generation)',
            '/iPhone11,2/' => 'iPhone XS',
            '/iPhone11,4/' => 'iPhone XS Max',
            '/iPhone11,6/' => 'iPhone XS Max',
            '/iPhone11,8/' => 'iPhone XR',
            '/iPhone10,3/' => 'iPhone X',
            '/iPhone10,6/' => 'iPhone X',
            '/iPhone9,1/' => 'iPhone 7',
            '/iPhone9,3/' => 'iPhone 7',
            '/iPhone9,2/' => 'iPhone 7 Plus',
            '/iPhone9,4/' => 'iPhone 7 Plus',
            '/iPhone8,1/' => 'iPhone 6s',
            '/iPhone8,2/' => 'iPhone 6s Plus',
        ];

        foreach ($models as $pattern => $model) {
            if (preg_match($pattern, $userAgent)) {
                return $model;
            }
        }

        // Fallback ke deteksi umum berdasarkan iOS version
        if (preg_match('/OS (\d+)_(\d+)/', $userAgent, $matches)) {
            $version = $matches[1] . '.' . $matches[2];
            return "iPhone (iOS $version)";
        }

        return 'iPhone';
    }

    private static function detectiPadModel($userAgent)
    {
        // iPad models
        $models = [
            '/iPad13,16/' => 'iPad Air (5th generation)',
            '/iPad13,17/' => 'iPad Air (5th generation)',
            '/iPad14,1/' => 'iPad mini (6th generation)',
            '/iPad14,2/' => 'iPad mini (6th generation)',
            '/iPad13,1/' => 'iPad Pro 11-inch (3rd generation)',
            '/iPad13,2/' => 'iPad Pro 11-inch (3rd generation)',
            '/iPad13,4/' => 'iPad Pro 12.9-inch (5th generation)',
            '/iPad13,5/' => 'iPad Pro 12.9-inch (5th generation)',
            '/iPad11,1/' => 'iPad mini (5th generation)',
            '/iPad11,2/' => 'iPad mini (5th generation)',
            '/iPad7,11/' => 'iPad (7th generation)',
            '/iPad7,12/' => 'iPad (7th generation)',
        ];

        foreach ($models as $pattern => $model) {
            if (preg_match($pattern, $userAgent)) {
                return $model;
            }
        }

        return 'iPad';
    }

    private static function detectAndroidModel($userAgent)
    {
        // Samsung Models
        if (preg_match('/SM-([A-Z0-9]+)/i', $userAgent, $matches)) {
            $samsungModels = [
                'SM-G998B' => 'Samsung Galaxy S21 Ultra',
                'SM-G996B' => 'Samsung Galaxy S21+',
                'SM-G991B' => 'Samsung Galaxy S21',
                'SM-G988B' => 'Samsung Galaxy S20 Ultra',
                'SM-G986B' => 'Samsung Galaxy S20+',
                'SM-G981B' => 'Samsung Galaxy S20',
                'SM-N986B' => 'Samsung Galaxy Note20 Ultra',
                'SM-N981B' => 'Samsung Galaxy Note20',
                'SM-A525F' => 'Samsung Galaxy A52s',
                'SM-A515F' => 'Samsung Galaxy A51',
                'SM-A715F' => 'Samsung Galaxy A71',
                'SM-A325F' => 'Samsung Galaxy A32',
                'SM-A225F' => 'Samsung Galaxy A22',
            ];

            $model = $matches[1];
            if (isset($samsungModels['SM-' . $model])) {
                return $samsungModels['SM-' . $model];
            }
            return "Samsung $model";
        }

        // Xiaomi Models
        if (preg_match('/(Mi|Redmi|POCO)\s+([A-Za-z0-9\s]+)/i', $userAgent, $matches)) {
            $brand = $matches[1];
            $model = trim($matches[2]);

            // Cleanup model name
            $model = preg_replace('/\s+/', ' ', $model);
            $model = preg_replace('/\s*Build.*$/i', '', $model);

            return "Xiaomi $brand $model";
        }

        // Oppo Models
        if (preg_match('/(CPH\d+|OPPO\s+[A-Za-z0-9]+)/i', $userAgent, $matches)) {
            $oppoModels = [
                'CPH2423' => 'OPPO Reno8',
                'CPH2413' => 'OPPO A96',
                'CPH2239' => 'OPPO Reno7',
                'CPH2127' => 'OPPO A74',
                'CPH2113' => 'OPPO A15s',
            ];

            $model = $matches[1];
            if (isset($oppoModels[$model])) {
                return $oppoModels[$model];
            }
            return "OPPO $model";
        }

        // Vivo Models
        if (preg_match('/(V\d+|vivo\s+[A-Za-z0-9]+)/i', $userAgent, $matches)) {
            $vivoModels = [
                'V2120' => 'Vivo V23',
                'V2111' => 'Vivo V21',
                'V2027' => 'Vivo Y20s',
                'V2031' => 'Vivo Y33s',
            ];

            $model = $matches[1];
            if (isset($vivoModels[$model])) {
                return $vivoModels[$model];
            }
            return "Vivo $model";
        }

        // Infinix Models
        if (preg_match('/Infinix\s+([A-Za-z0-9\s]+)/i', $userAgent, $matches)) {
            $model = trim($matches[1]);
            $model = preg_replace('/\s+/', ' ', $model);
            $model = preg_replace('/\s*Build.*$/i', '', $model);

            $infinixModels = [
                'X692' => 'Infinix Note 11',
                'X6812B' => 'Infinix Hot 10S',
                'X682B' => 'Infinix Hot 10',
                'X687' => 'Infinix Note 10',
                'X680D' => 'Infinix Hot 9',
                'X690B' => 'Infinix Note 11 Pro',
            ];

            // Check if it matches known model codes
            foreach ($infinixModels as $code => $name) {
                if (strpos($model, $code) !== false) {
                    return $name;
                }
            }

            return "Infinix $model";
        }

        // Realme Models
        if (preg_match('/(RMX\d+|realme\s+[A-Za-z0-9\s]+)/i', $userAgent, $matches)) {
            $realmeModels = [
                'RMX3516' => 'Realme 9 Pro+',
                'RMX3472' => 'Realme 9 Pro',
                'RMX3461' => 'Realme 9',
                'RMX3396' => 'Realme GT Neo 3',
                'RMX3371' => 'Realme GT 2 Pro',
                'RMX3031' => 'Realme 8',
                'RMX3085' => 'Realme 8 Pro',
            ];

            $model = $matches[1];
            if (isset($realmeModels[$model])) {
                return $realmeModels[$model];
            }
            return "Realme $model";
        }

        // Generic Android detection with version
        if (preg_match('/Android\s+(\d+\.?\d*)/i', $userAgent, $matches)) {
            $version = $matches[1];
            return "Android Phone (Android $version)";
        }

        // Fallback
        if (preg_match('/Mobile/i', $userAgent)) {
            return 'Android Phone';
        } else {
            return 'Android Tablet';
        }
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

    public static function getDeviceIcon($device)
    {
        // Get more specific icons based on detected device
        if (strpos($device, 'iPhone') !== false) {
            return 'fab fa-apple';
        } elseif (strpos($device, 'Samsung') !== false) {
            return 'fab fa-android';
        } elseif (strpos($device, 'Xiaomi') !== false) {
            return 'fab fa-android';
        } elseif (strpos($device, 'OPPO') !== false) {
            return 'fab fa-android';
        } elseif (strpos($device, 'Vivo') !== false) {
            return 'fab fa-android';
        } elseif (strpos($device, 'Infinix') !== false) {
            return 'fab fa-android';
        } elseif (strpos($device, 'Realme') !== false) {
            return 'fab fa-android';
        } elseif (strpos($device, 'iPad') !== false) {
            return 'fab fa-apple';
        } elseif (strpos($device, 'Android') !== false) {
            return 'fab fa-android';
        } elseif (strpos($device, 'Windows') !== false) {
            return 'fab fa-windows';
        } elseif (strpos($device, 'Mac') !== false) {
            return 'fab fa-apple';
        } elseif (strpos($device, 'Linux') !== false) {
            return 'fab fa-linux';
        }

        return 'fas fa-mobile-alt';
    }
}
