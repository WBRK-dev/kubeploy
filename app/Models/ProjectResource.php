<?php

namespace App\Models;

use App\Concerns\CreatesProjectResourceType;
use App\Concerns\GeneratesUniqueSelector;
use App\Enums\ProjectResourceType;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $project_id
 * @property string $name
 * @property string $selector
 * @property string $type
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read ProjectResourceApplication|null $applicationTrait
 * @property-read Project $project
 * @property-read ProjectResourceYaml|null $yamlTrait
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereSelector($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResource whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ProjectResource extends Model
{
    use CreatesProjectResourceType, GeneratesUniqueSelector;

    protected $fillable = [
        'project_id',
        'name',
        'selector',
        'type',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (ProjectResource $resource) {
            if (empty($resource->selector)) {
                $resource->selector = static::generateUniqueSelector($resource->project->name, $resource->name);
            }
        });
        static::created(fn (ProjectResource $resource) => static::createResourceTypeByType($resource));
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function loadType(): void
    {
        switch ($this->type) {
            case ProjectResourceType::Application->value:
                $this->load('applicationTrait');
                break;
            case ProjectResourceType::Yaml->value:
                $this->load('yamlTrait');
                break;
        }
    }

    public function applicationTrait(): HasOne
    {
        return $this->hasOne(ProjectResourceApplication::class);
    }

    public function yamlTrait(): HasOne
    {
        return $this->hasOne(ProjectResourceYaml::class);
    }
}
