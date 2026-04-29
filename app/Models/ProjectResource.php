<?php

namespace App\Models;

use App\Enums\ProjectResourceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $project_id
 * @property string $name
 * @property string $type
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\ProjectResourceYaml|null $yamlTrait
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectResource extends Model
{
    protected $fillable = [
        "project_id",
        "type",
    ];

    public function loadType(): void
    {
        switch($this->type) {
            case (ProjectResourceType::Yaml->value):
                $this->load("yamlTrait");
                break;
        }
    }

    public function yamlTrait(): HasOne
    {
        return $this->hasOne(ProjectResourceYaml::class);
    }
}
