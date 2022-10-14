<?php

namespace App\Auth\Providers;

use App\Enums\Role;
use Illuminate\Auth\EloquentUserProvider;

class AdminElequentProvider extends EloquentUserProvider
{
    protected function newModelQuery($model = null)
    {
        return parent::newModelQuery($model)->where('role', Role::Admin);
    }
}
