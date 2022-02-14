<?php

namespace App\Rules\Permission;

use App\Models\Permission;
use Illuminate\Contracts\Validation\ImplicitRule;

class UniquePermissionTypeExceptSelf implements ImplicitRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($permission_id)
    {
        $this->permission = Permission::findOrFail($permission_id);
        $this->group = Permission::findOrFail( $this->permission->parent_id);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->permission->type === $value || Permission::where('name', $this->group->name. '.' . $value)->count() === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Permission type already exists for this group.';
    }
}
