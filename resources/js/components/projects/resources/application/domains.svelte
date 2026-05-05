<script lang="ts">
    import Button from "@/components/ui/button.svelte";
    import Input from "@/components/ui/input.svelte";
    import DomainsTable from "./domains/domainsTable.svelte";
    import { Plus } from "@lucide/svelte";
    import type { ProjectResource } from "@/types";
    import NewDomainDialog from "./domains/newDomainDialog.svelte";

    let {
        resource,
        projectId,
        currentTeamSlug,
    }: {
        resource: ProjectResource,
        projectId: number,
        currentTeamSlug: string,
    } = $props();

    let isNewDomainDialogOpen = $state(false);
</script>

<div class="flex gap-3 mb-3">
    <Button
        label="Add Domain"
        icon={Plus}
        onclick={() => isNewDomainDialogOpen = true}
        className="shrink-0"
    />
    <Input
        placeholder="Search..."
    />
</div>

<DomainsTable
    rows={resource.application_trait!.domains}
    resourceId={resource.id}
    {projectId}
    {currentTeamSlug}
/>

<NewDomainDialog
    resourceId={resource.id}
    {currentTeamSlug}
    {projectId}
    open={isNewDomainDialogOpen}
    onclose={() => isNewDomainDialogOpen = false}
/>
