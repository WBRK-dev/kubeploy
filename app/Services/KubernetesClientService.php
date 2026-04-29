<?php

declare(strict_types=1);

namespace App\Services;

use Maclof\Kubernetes\Client;
use GuzzleHttp\Client as GuzzleClient;
use WbrkDev\KubernetesClientRepositories\RepositoryRegistry;

class KubernetesClientService
{
    public function createClient(string $kubeconfig): Client
    {
        // TODO: Manually store certificates instead of storing kubeconfig
        $config = Client::parseKubeconfig($kubeconfig);

        $httpClient = new GuzzleClient([
           	'verify' => $config['ca_cert'] ?? ($config['verify'] ?? null),
           	'cert' => $config['client_cert'] ?? null,
           	'ssl_key' => $config['client_key'] ?? null,
        ]);

        return new Client([
            'master' => $config['master'],
        ], new RepositoryRegistry(), $httpClient);
    }
}
