<script lang="ts">
    import { ExternalLink, Pencil, Trash } from 'lucide-svelte';
    import DataTable from '@/components/ui/dataTable.svelte';
    import { resource } from '@/routes/project';
    import type { ProjectResource } from '@/types';

    let {
        projectResources,
        projectId,
        teamSlug,
    }: {
        projectResources: ProjectResource[]
        projectId: number,
        teamSlug: string,
    } = $props();
</script>

{#snippet name(row: ProjectResource)}
    <a href={resource({ current_team: teamSlug, project: projectId, resource: row.id }).url} class="hover:underline">{row.name}</a>
{/snippet}

{#snippet actions(_: ProjectResource)}
    <div class="flex gap-2">
        <ExternalLink size={20} />
        <Pencil size={20} />
        <Trash size={20} color="red" />
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
