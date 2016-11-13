<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/post/users',
        'api/post/sessions',
        'api/post/orders',
        'api/post/rooms',
        'api/post/areas',
        'api/get/orders',
        'api/put/orders',
        'api/put/rooms',
        'api/delete/orders',
        'api/delete/rooms',
        'api/delete/areas'
        
    ];
}
