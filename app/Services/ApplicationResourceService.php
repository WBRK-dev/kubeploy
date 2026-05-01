<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ProjectResourceType;
use App\Exceptions\InvalidResourceTypeException;
use App\Models\ProjectResource;
use Maclof\Kubernetes\Client;
use Maclof\Kubernetes\Models\Deployment;

class ApplicationResourceService
{
    protected Client|null $client = null;

    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function deploy(ProjectResource $resource): void
    {
        if ($resource->type !== ProjectResourceType::Application->value)
            throw new InvalidResourceTypeException(ProjectResourceType::Application->value, $resource->type);

        $deployment = config('kubernetes.templates.application.deployment');

        $deployment['metadata']['name'] = $resource->selector;
        $deployment['metadata']['labels']['app'] = $resource->selector;
        $deployment['spec']['selector']['matchLabels']['app'] = $resource->selector;
        $deployment['spec']['template']['metadata']['labels']['app'] = $resource->selector;
        $deployment['spec']['template']['spec']['containers'][0]['name'] = $resource->selector;
        $deployment['spec']['template']['spec']['containers'][0]['image'] = $resource->applicationTrait->deployment['image'];
        $deployment['spec']['template']['spec']['containers'][0]['imagePullPolicy'] = $resource->applicationTrait->deployment['imagePullPolicy'];

        $deployment = new Deployment($deployment);

        if ($this->client->deployments()->exists($deployment->getMetadata('name'))) {
            $this->client->deployments()->update($deployment);
            return;
        }

        $this->client->deployments()->create($deployment);
    }
}
