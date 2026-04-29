<script lang="ts">
    import { inertia } from '@inertiajs/svelte';
    import { ExternalLink, Pencil, Trash } from '@lucide/svelte';
    import DataTable from '@/components/ui/dataTable.svelte';
    import { project } from '@/routes';
    import type { Project } from '@/types';
    import DeleteProjectDialog from './deleteProjectDialog.svelte';
    import EditProjectDialog from './editProjectDialog.svelte';

    let {
        projects,
        teamSlug,
    }: {
        projects: Project[]
        teamSlug: string,
    } = $props();

    let activeProject: Project|null = $state(null);
    let isDeleteProjectDialogOpen = $state(false);
    let isEditProjectDialogOpen = $state(false);
</script>

{#snippet name(row: Project)}
    <a
        href={project({ current_team: teamSlug, project: row.id }).url}
        use:inertia
        class="hover:underline"
    >{row.name}</a>
{/snippet}

{#snippet actions(project: Project)}
    <div class="flex gap-2">
        <ExternalLink size={20} />
        <button
            class="cursor-pointer"
            onclick={() => {
                isEditProjectDialogOpen = true;
                activeProject = project;
            }}
        >
            <Pencil size={20} />
        </button>
        <button
            class="cursor-pointer"
            onclick={() => {
                isDeleteProjectDialogOpen = true;
                activeProject = project;
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
            key: "actions",
            label: "Actions",
            render: actions,
        }
    ]}
    rows={projects}
/>

<DeleteProjectDialog
    project={activeProject}
    currentTeamSlug={teamSlug}
    open={isDeleteProjectDialogOpen}
    onclose={() => isDeleteProjectDialogOpen = false}
/>

<EditProjectDialog
    project={activeProject}
    currentTeamSlug={teamSlug}
    open={isEditProjectDialogOpen}
    onclose={() => isEditProjectDialogOpen = false}
/>
