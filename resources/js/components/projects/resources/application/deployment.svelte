<script lang="ts">
    import Tabs from "@/components/ui/tabs.svelte";
    import ApplicationType from "@/lib/enums/applicationType";
    import type { ProjectResource } from "@/types";
    import Docker from "./deployments/docker.svelte";

    let {
        resource,
        projectId,
        currentTeamSlug,
    }: {
        resource: ProjectResource,
        projectId: number,
        currentTeamSlug: string,
    } = $props();
</script>

<div class="border border-border rounded-card-lg p-4">
    <Tabs
        value="docker"
        items={[
            { label: 'Docker', value: ApplicationType.Docker, content: { component: Docker, props: { resource, projectId, currentTeamSlug } } }
        ]}
    />
</div>
