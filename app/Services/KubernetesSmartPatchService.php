<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\KubernetesKind;
use Maclof\Kubernetes\Client;
use Maclof\Kubernetes\Models\Deployment;

class KubernetesSmartPatchService
{
    protected ?Client $client = null;

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function patch(string $yaml): void
    {
        $patches = explode('---', $yaml);

        foreach ($patches as $patch) {
            $this->patchOne($patch);
        }
    }

    protected function patchOne(string $yaml): void
    {
        $kind = explode("\n", explode('kind: ', $yaml)[1])[0];
        switch ($kind) {
            case KubernetesKind::Deployment->value:
                $this->client->deployments()->apply(new Deployment(
                    [Deployment::MODEL_FROM_YAML => $yaml],
                    Deployment::MODEL_FROM_YAML,
                ));
                break;
        }
    }

    public function delete(string $yaml): void
    {
        $patches = explode('---', $yaml);

        foreach ($patches as $patch) {
            $this->deleteOne($patch);
        }
    }

    protected function deleteOne(string $yaml): void
    {
        $kind = explode("\n", explode('kind: ', $yaml)[1])[0];
        switch ($kind) {
            case KubernetesKind::Deployment->value:
                $this->client->deployments()->delete(new Deployment(
                    [Deployment::MODEL_FROM_YAML => $yaml],
                    Deployment::MODEL_FROM_YAML,
                ));
                break;
        }
    }
}
