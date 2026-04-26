<script lang="ts">
    import ProjectResourcesTable from "@/components/projects/projectResourcesTable.svelte";
    import type { Project, Team } from "@/types";

    let {
        project,
        currentTeam,
    }: {
        project: Project,
        currentTeam: Team,
    } = $props();
</script>

<h3 class="font-semibold text-xl mb-3">{project.name}</h3>

<ProjectResourcesTable
    projectResources={project.resources}
    projectId={project.id}
    teamSlug={currentTeam.slug}
/>
