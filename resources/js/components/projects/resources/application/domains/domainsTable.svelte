<script lang="ts">
    import { Pencil, Trash } from "@lucide/svelte";
    import DataTable from "@/components/ui/dataTable.svelte";
    import type { ProjectResourceApplicationDomain } from "@/types";
    import DeleteDomainDialog from "./deleteDomainDialog.svelte";
    import EditDomainDialog from "./editDomainDialog.svelte";

    let {
        rows,
        resourceId,
        projectId,
        currentTeamSlug,
    }: {
        rows: ProjectResourceApplicationDomain[],
        resourceId: number,
        projectId: number,
        currentTeamSlug: string,
    } = $props();

    let activeDomain: ProjectResourceApplicationDomain|null = $state(null);
    let isEditDomainDialogOpen = $state(false);
    let isDeleteDomainDialogOpen = $state(false);
</script>

{#snippet actions(domain: ProjectResourceApplicationDomain)}
    <div class="flex gap-2">
        <button
            class="cursor-pointer"
            onclick={() => {
                isEditDomainDialogOpen = true;
                activeDomain = domain;
            }}
        >
            <Pencil size={20} />
        </button>
        <button
            class="cursor-pointer"
            onclick={() => {
                isDeleteDomainDialogOpen = true;
                activeDomain = domain;
            }}
        >
            <Trash size={20} color="red" />
        </button>
    </div>
{/snippet}

<DataTable
    columns={[
        { key: 'domain', label: 'Domain' },
        { key: 'containerPort', label: 'Container Port' },
        { key: 'actions', label: 'Actions', render: actions },
    ]}
    {rows}
/>

<EditDomainDialog
    domain={activeDomain}
    {resourceId}
    {projectId}
    {currentTeamSlug}
    open={isEditDomainDialogOpen}
    onclose={() => isEditDomainDialogOpen = false}
/>

<DeleteDomainDialog
    domain={activeDomain}
    {resourceId}
    {projectId}
    {currentTeamSlug}
    open={isDeleteDomainDialogOpen}
    onclose={() => isDeleteDomainDialogOpen = false}
/>
