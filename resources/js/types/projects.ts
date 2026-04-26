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
    type: string;
    yaml_trait?: ProjectResourceYaml;
    created_at: string;
    updated_at: string;
};

export type ProjectResourceYaml = {
    id: number;
    yaml: string;
    created_at: string;
    updated_at: string;
};
