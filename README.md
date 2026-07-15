# AgriServ Departments

Receive and sync department updates from the AgriServ central system into your Laravel application.

## Requirements

- PHP 8.2+
- Laravel 11+

## Installation

```bash
composer require agriserv/departments
```

Publish the config file:

```bash
php artisan vendor:publish --tag=departments-config
```

Add the secret key to your `.env`:

```env
SSO_SECRET_KEY=your-secret-key
```

## How It Works

Once installed, the package registers a single endpoint:

```
POST /api/departments/sync
```

The central AgriServ system calls this endpoint whenever a department's `manager_id` changes, passing the department `key` and the new `manager_id`.

**Request:**
```
POST /api/departments/sync
X-Token: your-secret-key

{
    "key": "finance",
    "manager_id": "098765"
}
```

**Responses:**

| Status | Meaning |
|--------|---------|
| `200` | Department updated successfully |
| `401` | Invalid or missing `X-Token` |
| `404` | Department key not found |
| `422` | Validation failed |

## Handling the Sync

The package does **not** manage your database. You are responsible for handling how the department is updated by extending the base controller.

**1. Create your controller:**

```php
<?php

namespace App\Http\Controllers;

use Agriserv\Departments\Http\Controllers\DepartmentSyncController as BaseController;
use App\Models\Department;

class DepartmentSyncController extends BaseController
{
    protected function sync(string $key, string $managerId): bool
    {
        return (bool) Department::where('key', $key)->update(['manager_id' => $managerId]);
    }
}
```

**2. Point to it in `config/departments.php`:**

```php
'controller' => App\Http\Controllers\DepartmentSyncController::class,
```

You can also override `__invoke()` entirely if you need to customize the response or add extra logic.

## Configuration

```php
// config/departments.php

return [
    // The secret key sent by the central system in the X-Token header.
    'secret_token' => env('SSO_SECRET_KEY'),

    // The controller that handles the sync request.
    'controller' => \Agriserv\Departments\Http\Controllers\DepartmentSyncController::class,
];
```

## License

MIT
