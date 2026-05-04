<?php

return [
    'kubeconfig' => 'apiVersion: v1
clusters:
- cluster:
    certificate-authority: "/home/www-data/.minikube/ca.crt"
    extensions:
    - extension:
        last-update: "Tue, 28 Apr 2026 15:06:22 CEST"
        provider: minikube.sigs.k8s.io
        version: v1.37.0
        name: cluster_info
    server: "https://192.168.49.2:8443"
  name: minikube
contexts:
- context:
    cluster: minikube
    extensions:
    - extension:
        last-update: "Tue, 28 Apr 2026 15:06:22 CEST"
        provider: minikube.sigs.k8s.io
        version: v1.37.0
        name: context_info
    namespace: default
    user: minikube
  name: minikube
current-context: minikube
kind: Config
users:
- name: minikube
  user:
    client-certificate: "/home/www-data/.minikube/profiles/minikube/client.crt"
    client-key: "/home/www-data/.minikube/profiles/minikube/client.key"',

    'templates' => [
        'application' => [
            'deployment' => [
                'apiVersion' => 'apps/v1',
                'kind' => 'Deployment',
                'metadata' => [
                    'name' => 'hello-world',
                    'labels' => [
                        'app' => 'hello-world',
                    ],
                ],
                'spec' => [
                    'replicas' => 1,
                    'selector' => [
                        'matchLabels' => [
                            'app' => 'hello-world',
                        ],
                    ],
                    'template' => [
                        'metadata' => [
                            'labels' => [
                                'app' => 'hello-world',
                            ],
                        ],
                        'spec' => [
                            'containers' => [
                                [
                                    'name' => 'hello-world',
                                    'image' => 'hello-world:latest',
                                    'imagePullPolicy' => 'IfNotPresent',
                                    // 'ports' => [
                                    //     ['containerPort' => 80],
                                    // ],
                                    // 'resources' => [
                                    //     'requests' => [
                                    //         'cpu'    => '50m',
                                    //         'memory' => '64Mi',
                                    //     ],
                                    //     'limits' => [
                                    //         'cpu'    => '100m',
                                    //         'memory' => '128Mi',
                                    //     ],
                                    // ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'service' => [
                'apiVersion' => 'v1',
                'kind' => 'Service',
                'metadata' => [
                    'name' => 'nginx',
                    'labels' => [
                        'app' => 'nginx',
                    ],
                    'annotations' => [
                        'metallb.io/address-pool' => 'node1-pool',
                        'metallb.io/allow-shared-ip' => 'kubeploy',
                    ],
                ],
                'spec' => [
                    'ports' => [
                        [
                            'port' => 80,
                            'targetPort' => 80,
                        ],
                    ],
                    'selector' => [
                        'app' => 'nginx',
                    ],
                    'type' => 'LoadBalancer',
                ],
            ],
        ],
    ],
];
