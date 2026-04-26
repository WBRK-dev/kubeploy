<script lang="ts">
    import ProjectsTable from "@/components/projects/projectsTable.svelte";
    import type { Project, Team } from "@/types";

    let {
        projects,
        currentTeam,
    }: {
        projects: Project[],
        currentTeam: Team,
    } = $props();
</script>

<h3 class="font-semibold text-xl mb-3">Projects</h3>

<ProjectsTable
    {projects}
    teamSlug={currentTeam.slug}
/>
