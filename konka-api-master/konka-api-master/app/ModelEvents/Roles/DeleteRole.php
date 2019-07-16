<?php

namespace App\ModelEvents\Roles;

use App\Models\Role;

class DeleteRole
{
    /**
     * @var Role
     */

    public $model;

    /**
     * EnabledRole constructor.
     * @param Role $model
     */

    public function __construct(Role $model)
    {
        $this->model = $model;
    }
}
