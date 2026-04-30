<script lang="ts">
    import { Plus } from "@lucide/svelte";
    import NewResourceDialog from "@/components/projects/newResourceDialog.svelte";
    import ProjectResourcesTable from "@/components/projects/projectResourcesTable.svelte";
    import Button from "@/components/ui/button.svelte";
    import type { Project, Team } from "@/types";

    let {
        project,
        currentTeam,
    }: {
        project: Project,
        currentTeam: Team,
    } = $props();

    let isNewResourceDialogOpen = $state(false);
</script>

<h3 class="font-semibold text-xl mb-3">{project.name}</h3>

<div class="flex gap-3 mb-3">
    <Button
        label="Create Resource"
        icon={Plus}
        onclick={() => isNewResourceDialogOpen = true}
    />
</div>

<ProjectResourcesTable
    projectResources={project.resources}
    projectId={project.id}
    teamSlug={currentTeam.slug}
/>

<NewResourceDialog
    projectId={project.id}
    currentTeamSlug={currentTeam.slug}
    open={isNewResourceDialogOpen}
    onclose={() => isNewResourceDialogOpen = false}
/>
