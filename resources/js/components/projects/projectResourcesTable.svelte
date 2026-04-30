<script lang="ts">
    import { inertia } from '@inertiajs/svelte';
    import { ExternalLink, Pencil, Trash } from '@lucide/svelte';
    import DataTable from '@/components/ui/dataTable.svelte';
    import { resource } from '@/routes/project';
    import type { ProjectResource } from '@/types';
    import DeleteProjectResourceDialog from './deleteProjectResourceDialog.svelte';
    import EditProjectResourceDialog from './editProjectResourceDialog.svelte';

    let {
        projectResources,
        projectId,
        teamSlug,
    }: {
        projectResources: ProjectResource[]
        projectId: number,
        teamSlug: string,
    } = $props();

    let activeProjectResource: ProjectResource|null = $state(null);
    let isEditProjectResourceDialogOpen = $state(false);
    let isDeleteProjectResourceDialogOpen = $state(false);
</script>

{#snippet name(row: ProjectResource)}
    <a
        href={resource({ current_team: teamSlug, project: projectId, resource: row.id }).url}
        use:inertia
        class="hover:underline"
    >{row.name}</a>
{/snippet}

{#snippet actions(projectResource: ProjectResource)}
    <div class="flex gap-2">
        <ExternalLink size={20} />
        <button
            class="cursor-pointer"
            onclick={() => {
                isEditProjectResourceDialogOpen = true;
                activeProjectResource = projectResource;
            }}
        >
            <Pencil size={20} />
        </button>
        <button
            class="cursor-pointer"
            onclick={() => {
                isDeleteProjectResourceDialogOpen = true;
                activeProjectResource = projectResource;
            }}
        >
            <Trash size={20} color="red" />
        </button>
    </div>
{/snippet}

<DataTable
    columns={[
        {
            key: "name",
            label: "Name",
            render: name,
        },
        {
            key: "type",
            label: "Type",
        },
        {
            key: "actions",
            label: "Actions",
            render: actions,
        }
    ]}
    rows={projectResources}
/>

<DeleteProjectResourceDialog
    projectResource={activeProjectResource}
    {projectId}
    currentTeamSlug={teamSlug}
    open={isDeleteProjectResourceDialogOpen}
    onclose={() => isDeleteProjectResourceDialogOpen = false}
/>

<EditProjectResourceDialog
    projectResource={activeProjectResource}
    {projectId}
    currentTeamSlug={teamSlug}
    open={isEditProjectResourceDialogOpen}
    onclose={() => isEditProjectResourceDialogOpen = false}
/>
