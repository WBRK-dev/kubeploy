<?php

use App\Services\KubernetesClientService;
use Maclof\Kubernetes\Client;

test('creates client with kubeconfig', function () {
    $service = new KubernetesClientService;
    $kubeconfig = 'fake kubeconfig content'; // In real test, use a valid one or mock

    $client = $service->createClient($kubeconfig);

    expect($client)->toBeInstanceOf(Client::class);
});
