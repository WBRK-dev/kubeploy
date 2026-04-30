import type ApplicationType from "@/lib/enums/applicationType";
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
    yaml_trait?: ProjectResourceYaml;
    created_at: string;
    updated_at: string;
};

export type ProjectResourceApplication = {
    id: number;
    deployment: ProjectResourceApplicationDeployment;
    domains: [];
    ports: [];
    created_at: string;
    updated_at: string;
};

export type ProjectResourceApplicationDeployment = {
    type: ApplicationType;
};

export type ProjectResourceYaml = {
    id: number;
    yaml: string;
    created_at: string;
    updated_at: string;
};
