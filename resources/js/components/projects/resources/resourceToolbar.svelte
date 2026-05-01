<script lang="ts">
    import { useHttp } from "@inertiajs/svelte";
    import { CircleStop, FileBraces, RefreshCw, Rocket, Trash } from "@lucide/svelte";
    import Button from "@/components/ui/button.svelte";
    import ProjectResourceType from "@/lib/enums/projectResourceType";
    import { apply as yamlApplyRoute, deleteMethod as yamlDeleteRoute } from '@/routes/project/resource/yaml';
    import type { Project, ProjectResource, Team } from '@/types';

    let {
        project,
        resource,
        currentTeam,
        className = '',
    }: {
        project: Project,
        resource: ProjectResource,
        currentTeam: Team,
        className?: string,
    } = $props();

    const http = useHttp();

    function onapply() {
        http.post(yamlApplyRoute({ current_team: currentTeam.slug, project: project.id, resource: resource.id }).url);
    }

    function ondelete() {
        http.post(yamlDeleteRoute({ current_team: currentTeam.slug, project: project.id, resource: resource.id }).url);
    }
</script>

<div class="flex gap-4 {className}">
    {#if [ProjectResourceType.Application].includes(resource.type)}
        <Button
            label="Deploy"
            icon={Rocket}
            spinner={http.processing}
        />
    {/if}
    {#if [ProjectResourceType.Yaml].includes(resource.type)}
        <Button
            label="Apply"
            icon={FileBraces}
            onclick={onapply}
            spinner={http.processing}
        />
    {/if}
    {#if [ProjectResourceType.Application].includes(resource.type)}
        <Button
            label="Reload"
            icon={RefreshCw}
            kind="secondary"
            spinner={http.processing}
        />
    {/if}
    {#if [ProjectResourceType.Application].includes(resource.type)}
        <Button
            label="Stop"
            icon={CircleStop}
            kind="danger"
            spinner={http.processing}
        />
    {/if}
    {#if [ProjectResourceType.Yaml].includes(resource.type)}
        <Button
            label="Delete"
            icon={Trash}
            kind="danger"
            onclick={ondelete}
            spinner={http.processing}
        />
    {/if}
</div>
