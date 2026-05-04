<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $project_resource_id
 * @property array<array-key, mixed> $deployment
 * @property array<array-key, mixed> $domains
 * @property array<array-key, mixed> $ports
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication whereDeployment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication whereDomains($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication wherePorts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication whereProjectResourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceApplication whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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
