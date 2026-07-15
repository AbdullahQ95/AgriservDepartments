<?php

return [

    /*
     * The secret token the central system sends in X-Token header.
     */
    'secret_token' => env('SSO_SECRET_KEY'),

    /*
     * The controller that handles the sync request.
     * Override by extending DepartmentSyncController and pointing here.
     */
    'controller' => \Agriserv\Departments\Http\Controllers\DepartmentSyncController::class,
];
