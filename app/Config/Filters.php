<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'isLoggedIn'     => \App\Filters\Authentication::class,
        'isGranted'     => \App\Filters\Authorization::class,
        'check-admin' => \App\Filters\CheckAdmin::class,
        'isMaintenance' => \App\Filters\Maintenance::class,
        'secure-api'     => \App\Filters\SecureAPI::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            'csrf' => ['except' => ['vr-run-internal-cron', 'api/*']],
            // 'invalidchars',
            'isLoggedIn'    => ['except' => ['/', 'Auth/*', 'api/*', 'blocked', 'maintenance']],
            'isGranted'     => ['except' => ['/', 'Auth/*', 'api/*', 'blocked', 'maintenance']],
            'isMaintenance' => ['except' => ['Auth/*', 'api/*', 'blocked', 'admin/*', 'maintenance']],
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
