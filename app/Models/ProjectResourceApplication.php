<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['project_resource_id', 'deployment', 'domains', 'ports'])]
class ProjectResourceApplication extends Model
{
    /**
        * Get the attributes that should be cast.
        *
        * @return array<string, string>
        */
    protected function casts(): array
    {
        return [
            'deployment' => 'array',
            'domains' => 'array',
            'ports' => 'array',
        ];
    }
}
