<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ProjectResourceType;
use App\Exceptions\InvalidResourceTypeException;
use App\Models\ProjectResource;
use Maclof\Kubernetes\Client;
use Maclof\Kubernetes\Models\Deployment;
use Maclof\Kubernetes\Models\Service;

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
        } else {
            $this->client->deployments()->create($deployment);
        }

        foreach ($resource->applicationTrait->ports as $port) {
            $service = $this->createService(
                $resource,
                $port['selector'],
                (int) $port['hostPort'],
                (int) $port['containerPort'],
            );
            if ($this->client->services()->exists($service->getMetadata('name')))
                $this->client->services()->update($service);
            else
                $this->client->services()->create($service);
        }
    }

    protected function createService(ProjectResource $resource, string $selector, int $hostPort, int $targetPort): Service
    {
        $service = config('kubernetes.templates.application.service');

        $uniqueName = "$resource->selector-$selector";
        $service['metadata']['name'] = $uniqueName;
        $service['metadata']['labels']['name'] = $resource->selector;
        $service['spec']['ports'][0]['port'] = $hostPort;
        $service['spec']['ports'][0]['targetPort'] = $targetPort;
        $service['spec']['selector']['app'] = $resource->selector;

        return new Service($service);
    }
}
