<script lang="ts">
    import { Pencil, Trash } from "@lucide/svelte";
    import DataTable from "@/components/ui/dataTable.svelte";
    import type { ProjectResourceApplicationPort } from "@/types";
    import DeletePortDialog from "./deletePortDialog.svelte";
    import EditPortDialog from "./editPortDialog.svelte";

    let {
        rows,
        resourceId,
        projectId,
        currentTeamSlug,
    }: {
        rows: ProjectResourceApplicationPort[],
        resourceId: number,
        projectId: number,
        currentTeamSlug: string,
    } = $props();

    let activePort: ProjectResourceApplicationPort|null = $state(null);
    let isEditPortDialogOpen = $state(false);
    let isDeletePortDialogOpen = $state(false);
</script>

{#snippet actions(port: ProjectResourceApplicationPort)}
    <div class="flex gap-2">
        <button
            class="cursor-pointer"
            onclick={() => {
                isEditPortDialogOpen = true;
                activePort = port;
            }}
        >
            <Pencil size={20} />
        </button>
        <button
            class="cursor-pointer"
            onclick={() => {
                isDeletePortDialogOpen = true;
                activePort = port;
            }}
        >
            <Trash size={20} color="red" />
        </button>
    </div>
{/snippet}

<DataTable
    columns={[
        { key: 'hostPort', label: 'Host Port' },
        { key: 'containerPort', label: 'Container Port' },
        { key: 'actions', label: 'Actions', render: actions },
    ]}
    {rows}
/>

<EditPortDialog
    port={activePort}
    {resourceId}
    {projectId}
    {currentTeamSlug}
    open={isEditPortDialogOpen}
    onclose={() => isEditPortDialogOpen = false}
/>

<DeletePortDialog
    port={activePort}
    {resourceId}
    {projectId}
    {currentTeamSlug}
    open={isDeletePortDialogOpen}
    onclose={() => isDeletePortDialogOpen = false}
/>
