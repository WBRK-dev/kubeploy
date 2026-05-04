<?php

use App\Enums\ProjectResourceType;
use App\Exceptions\InvalidResourceTypeException;
use App\Models\ProjectResource;
use App\Models\ProjectResourceApplication;
use App\Services\ApplicationResourceService;
use Maclof\Kubernetes\Client;
use Maclof\Kubernetes\Models\Deployment;
use Maclof\Kubernetes\Models\Service;
use Mockery;

test('deploys application resource', function () {
    $client = Mockery::mock(Client::class);
    $deployments = Mockery::mock();
    $services = Mockery::mock();
    $client->shouldReceive('deployments')->andReturn($deployments);
    $client->shouldReceive('services')->andReturn($services);
    $deployments->shouldReceive('exists')->andReturn(false);
    $deployments->shouldReceive('create')->once()->with(Mockery::type(Deployment::class));
    $services->shouldReceive('exists')->andReturn(false);
    $services->shouldReceive('create')->once()->with(Mockery::type(Service::class));
    $services->shouldReceive('setLabelSelector')->andReturn($services);
    $services->shouldReceive('find')->andReturn([]);

    $service = new ApplicationResourceService;
    $service->setClient($client);

    $application = Mockery::mock(ProjectResourceApplication::class);
    $application->shouldReceive('getAttribute')->with('deployment')->andReturn(['image' => 'nginx', 'imagePullPolicy' => 'Always']);
    $application->shouldReceive('getAttribute')->with('ports')->andReturn([['selector' => 'port1', 'hostPort' => 80, 'containerPort' => 80]]);

    $resource = Mockery::mock(ProjectResource::class);
    $resource->shouldReceive('getAttribute')->with('type')->andReturn(ProjectResourceType::Application->value);
    $resource->shouldReceive('getAttribute')->with('selector')->andReturn('test-selector');
    $resource->shouldReceive('getAttribute')->with('applicationTrait')->andReturn($application);

    $service->deploy($resource);
});

test('throws exception for invalid resource type', function () {
    $service = new ApplicationResourceService;

    $resource = Mockery::mock(ProjectResource::class);
    $resource->shouldReceive('getAttribute')->with('type')->andReturn(ProjectResourceType::Yaml->value);

    expect(fn () => $service->deploy($resource))->toThrow(InvalidResourceTypeException::class);
});
