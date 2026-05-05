import type ApplicationType from "@/lib/enums/applicationType";
import type ImagePullPolicy from "@/lib/enums/imagePullPolicy";
import type ProjectResourceType from "@/lib/enums/projectResourceType";

export type Project = {
    id: number;
    name: string;
    resources: ProjectResource[];
    created_at: string;
    updated_at: string;
};

export type ProjectResource = {
    id: number;
    name: string;
    type: ProjectResourceType;
    application_trait?: ProjectResourceApplication;
    yaml_trait?: ProjectResourceYaml;
    created_at: string;
    updated_at: string;
};

export type ProjectResourceApplication = {
    id: number;
    deployment: ProjectResourceApplicationDeployment;
    domains: ProjectResourceApplicationDomain[];
    ports: ProjectResourceApplicationPort[];
    created_at: string;
    updated_at: string;
};

export type ProjectResourceApplicationDeployment = (
    | { type: ApplicationType.Docker, image: string, imagePullPolicy: ImagePullPolicy }
);

export type ProjectResourceApplicationDomain = {
    selector?: string;
    domain: string;
    containerPort: string;
};

export type ProjectResourceApplicationPort = {
    selector?: string;
    hostPort: string;
    containerPort: string;
};

export type ProjectResourceYaml = {
    id: number;
    yaml: string;
    created_at: string;
    updated_at: string;
};
