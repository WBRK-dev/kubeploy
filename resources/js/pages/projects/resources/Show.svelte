<script lang="ts">
    import { inertia } from "@inertiajs/svelte";
    import YamlResource from "@/components/projects/resources/yamlResource.svelte";
    import { project as projectRoute } from "@/routes";
    import type { Project, ProjectResource, Team } from "@/types";
    import ResourceToolbar from "@/components/projects/resources/resourceToolbar.svelte";

    let {
        project,
        resource,
        currentTeam,
    }: {
        project: Project,
        resource: ProjectResource,
        currentTeam: Team,
    } = $props();
</script>

<h3 class="font-semibold text-xl mb-3">
    <a
        href={projectRoute({ current_team: currentTeam.slug, project: project.id }).url}
        use:inertia
        class="hover:underline"
    >
        {project.name}
    </a> / {resource.name}
</h3>

<ResourceToolbar
    className="mb-3"
/>

{#if resource.type === "yaml"}
    <YamlResource
        {project}
        {resource}
        {currentTeam}
    />
{/if}
