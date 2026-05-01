<script lang="ts">
    import { inertia } from "@inertiajs/svelte";
    import ApplicationResource from "@/components/projects/resources/applicationResource.svelte";
    import ResourceToolbar from "@/components/projects/resources/resourceToolbar.svelte";
    import YamlResource from "@/components/projects/resources/yamlResource.svelte";
    import ProjectResourceType from "@/lib/enums/projectResourceType";
    import { project as projectRoute } from "@/routes";
    import type { Project, ProjectResource, Team } from "@/types";

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
    {project}
    {resource}
    {currentTeam}
    className="mb-3"
/>

{#if resource.type === ProjectResourceType.Application}
    <ApplicationResource
        {project}
        {resource}
        {currentTeam}
    />
{:else if resource.type === ProjectResourceType.Yaml}
    <YamlResource
        {project}
        {resource}
        {currentTeam}
    />
{/if}
