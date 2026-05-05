<script lang="ts">
    import { Forward } from "@lucide/svelte";
    import Button from "@/components/ui/button.svelte";
    import Input from "@/components/ui/input.svelte";
    import type { ProjectResource } from "@/types";
    import NewPortDialog from "./ports/newPortDialog.svelte";
    import PortsTable from "./ports/portsTable.svelte";

    let {
        resource,
        projectId,
        currentTeamSlug,
    }: {
        resource: ProjectResource,
        projectId: number,
        currentTeamSlug: string,
    } = $props();

    let isNewPortDialogOpen = $state(false);
</script>

<div class="flex gap-3 mb-3">
    <Button
        label="Forward Port"
        icon={Forward}
        onclick={() => isNewPortDialogOpen = true}
        className="shrink-0"
    />
    <Input
        placeholder="Search..."
    />
</div>

<PortsTable
    rows={resource.application_trait!.ports}
    resourceId={resource.id}
    {projectId}
    {currentTeamSlug}
/>

<NewPortDialog
    resourceId={resource.id}
    {currentTeamSlug}
    {projectId}
    open={isNewPortDialogOpen}
    onclose={() => isNewPortDialogOpen = false}
/>
