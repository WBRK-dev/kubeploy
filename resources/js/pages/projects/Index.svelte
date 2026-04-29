<script lang="ts">
    import { Plus } from "@lucide/svelte";
    import NewProjectDialog from "@/components/projects/newProjectDialog.svelte";
    import ProjectsTable from "@/components/projects/projectsTable.svelte";
    import Button from "@/components/ui/button.svelte";
    import type { Project, Team } from "@/types";

    let {
        projects,
        currentTeam,
    }: {
        projects: Project[],
        currentTeam: Team,
    } = $props();

    let isNewProjectDialogOpen = $state(false);
</script>

<h3 class="font-semibold text-xl mb-3">Projects</h3>

<div class="flex gap-3 mb-3">
    <Button
        label="Create"
        icon={Plus}
        onclick={() => isNewProjectDialogOpen = true}
    />
</div>

<ProjectsTable
    {projects}
    teamSlug={currentTeam.slug}
/>

<NewProjectDialog
    currentTeamSlug={currentTeam.slug}
    open={isNewProjectDialogOpen}
    onclose={() => isNewProjectDialogOpen = false}
/>
