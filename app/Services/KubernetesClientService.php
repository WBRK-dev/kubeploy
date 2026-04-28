<?php

declare(strict_types=1);

namespace App\Services;

use Maclof\Kubernetes\Client;
use Http\Adapter\Guzzle6\Client as Guzzle6Client;
use WbrkDev\KubernetesClientRepositories\RepositoryRegistry;

class KubernetesClientService
{
    public function createClient(string $kubeconfig): Client
    {
        // TODO: Manually store certificates instead of storing kubeconfig
        $config = Client::parseKubeconfig($kubeconfig);

        $httpClient = Guzzle6Client::createWithConfig([
           	'verify' => $config['ca_cert'],
           	'cert' => $config['client_cert'],
           	'ssl_key' => $config['client_key'],
        ]);

        return new Client([
            'master' => $config['master'],
        ], new RepositoryRegistry(), $httpClient);
    }
}
