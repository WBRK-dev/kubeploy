<script lang="ts">
    import YamlResource from "@/components/projects/resources/yamlResource.svelte";
    import type { Project, ProjectResource } from "@/types";

    let {
        project,
        resource,
    }: {
        project: Project,
        resource: ProjectResource,
    } = $props();
    $inspect(resource)
</script>

<h3 class="font-semibold text-xl mb-3">{project.name} / {resource.name}</h3>

{#if resource.type === "yaml"}
    <YamlResource
        {project}
        {resource}
    />
{/if}
