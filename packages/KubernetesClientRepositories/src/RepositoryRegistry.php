<?php

namespace WbrkDev\KubernetesClientRepositories;

use Maclof\Kubernetes\Repositories;
use Maclof\Kubernetes\RepositoryRegistry as MaclofRepositoryRegistry;

/**
 * @implements ArrayAccess<string, Repository>
 */
class RepositoryRegistry extends MaclofRepositoryRegistry implements \ArrayAccess, \Countable
{
    protected array $map = [
        'nodes' => Repositories\NodeRepository::class,
        'quotas' => Repositories\QuotaRepository::class,
        'pods' => Repositories\PodRepository::class,
        'replicaSets' => Repositories\ReplicaSetRepository::class,
        'replicationControllers' => Repositories\ReplicationControllerRepository::class,
        'services' => Repositories\ServiceRepository::class,
        'secrets' => Repositories\SecretRepository::class,
        'events' => Repositories\EventRepository::class,
        'configMaps' => Repositories\ConfigMapRepository::class,
        'endpoints' => Repositories\EndpointRepository::class,
        'persistentVolume' => Repositories\PersistentVolumeRepository::class,
        'persistentVolumeClaims' => Repositories\PersistentVolumeClaimRepository::class,
        'namespaces' => Repositories\NamespaceRepository::class,
        'serviceAccounts' => Repositories\ServiceAccountRepository::class,

        // batch/v1
        'jobs' => Repositories\JobRepository::class,

        // batch/v2
        'cronJobs' => Repositories\CronJobRepository::class,

        // apps/v1
        'deployments' => Repositories\DeploymentRepository::class,

        // extensions/v1
        'daemonSets' => Repositories\DaemonSetRepository::class,
        'ingresses' => Repositories\IngressRepository::class,

        // autoscaling/v2
        'horizontalPodAutoscalers' => Repositories\HorizontalPodAutoscalerRepository::class,

        // networking.k8s.io/v1
        'networkPolicies' => Repositories\NetworkPolicyRepository::class,

        // certmanager.k8s.io/v1
        'certificates' => Repositories\CertificateRepository::class,
        'issuers' => Repositories\IssuerRepository::class,

        // rbac.authorization.k8s.io/v1
        'roles' => Repositories\RoleRepository::class,
        'roleBindings' => Repositories\RoleBindingRepository::class,
    ];
}
