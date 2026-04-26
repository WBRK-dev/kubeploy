<script lang="ts">
    import ProjectTable from "@/components/projects/projectTable.svelte";
    import type { Project } from "@/types";

    let {
        projects,
        currentTeam,
    }: {
        projects: Project[],
        currentTeam: any,
    } = $props();
</script>

<h3 class="font-semibold text-xl mb-3">Projects</h3>

<ProjectTable
    {projects}
    teamSlug={currentTeam.slug}
/>
