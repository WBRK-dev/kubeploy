<script lang="ts">
    import Tabs from "@/components/ui/tabs.svelte";
    import type { Project, ProjectResource, Team } from "@/types";
    import Deployment from "./application/deployment.svelte";
    import Domains from "./application/domains.svelte";
    import Environment from "./application/environment.svelte";
    import Ports from "./application/ports.svelte";

    let {
        project,
        resource,
        currentTeam,
    }: {
        project: Project,
        resource: ProjectResource,
        currentTeam: Team,
    } = $props();
</script>

<Tabs
    value="deployment"
    items={[
        { label: 'Deployment', value: 'deployment', content: { component: Deployment, props: { resource, projectId: project.id, currentTeamSlug: currentTeam.slug } } },
        { label: 'Environment', value: 'environment', content: { component: Environment } },
        { label: 'Domains', value: 'domains', content: { component: Domains } },
        { label: 'Ports', value: 'ports', content: { component: Ports } },
    ]}
/>
