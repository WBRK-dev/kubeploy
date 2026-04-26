<script lang="ts">
    import { ExternalLink, Pencil, Trash } from 'lucide-svelte';
    import DataTable from '@/components/ui/dataTable.svelte';
    import { project } from '@/routes';
    import type { Project } from '@/types';

    let {
        projects,
        teamSlug,
    }: {
        projects: Project[]
        teamSlug: string,
    } = $props();
</script>

{#snippet name(row: Project)}
    <a href={project({ current_team: teamSlug, project: row.id }).url} class="hover:underline">{row.name}</a>
{/snippet}

{#snippet actions(_: Project)}
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
            key: "actions",
            label: "Actions",
            render: actions,
        }
    ]}
    rows={projects}
/>
