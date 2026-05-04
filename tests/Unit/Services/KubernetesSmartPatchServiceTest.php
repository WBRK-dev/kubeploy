<?php

use App\Services\KubernetesSmartPatchService;
use Maclof\Kubernetes\Client;
use Maclof\Kubernetes\Models\Deployment;
use Mockery;

test('patches deployment yaml', function () {
    $client = Mockery::mock(Client::class);
    $deployments = Mockery::mock();
    $client->shouldReceive('deployments')->andReturn($deployments);
    $deployments->shouldReceive('apply')->once()->with(Mockery::type(Deployment::class));

    $service = new KubernetesSmartPatchService;
    $service->setClient($client);

    $yaml = "apiVersion: apps/v1\nkind: Deployment\nmetadata:\n  name: test\nspec:\n  replicas: 1";

    $service->patch($yaml);
});

test('deletes deployment yaml', function () {
    $client = Mockery::mock(Client::class);
    $deployments = Mockery::mock();
    $client->shouldReceive('deployments')->andReturn($deployments);
    $deployments->shouldReceive('delete')->once()->with(Mockery::type(Deployment::class));

    $service = new KubernetesSmartPatchService;
    $service->setClient($client);

    $yaml = "apiVersion: apps/v1\nkind: Deployment\nmetadata:\n  name: test\nspec:\n  replicas: 1";

    $service->delete($yaml);
});
