<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { Label } from "bits-ui";
    import { resource as resourceRoute } from '@/routes/project';
    import { ProjectResourceType } from "@/types";
    import type { ProjectResource } from "@/types";
    import type { SelectItem } from "@/types/components/ui/select";
    import Button from "../ui/button.svelte";
    import Dialog from "../ui/dialog.svelte";
    import Input from "../ui/input.svelte";
    import Select from "../ui/select.svelte";

    let {
        projectResource,
        projectId,
        currentTeamSlug,
        open,
        onclose,
    }: {
        projectResource: ProjectResource|null,
        projectId: number,
        currentTeamSlug: string,
        open: boolean,
        onclose: () => void,
    } = $props();

    const form = useForm({
        name: '',
    });

    $effect(() => {
        if (open && projectResource) {
            form.name = projectResource.name;
        }
    });

    const resourceTypes: SelectItem[] = [
        { label: 'Application', value: ProjectResourceType.Application },
        { label: 'Yaml', value: ProjectResourceType.Yaml },
    ];
</script>

<Dialog
    title="Edit Project Resource"
    {open}
    {onclose}
>
    <Label.Root for="name">Name</Label.Root>
    <Input
        id="name"
        placeholder="Postgres"
        bind:value={form.name}
    />

    {#if form.errors.name}
        <p class="text-red-500 text-sm mt-2">{form.errors.name}</p>
    {/if}

    <div class="mt-3"></div>
    <Label.Root>Type</Label.Root>
    <Select
        items={resourceTypes}
        value={projectResource?.type}
        placeholder="Select resource type"
        disabled={true}
    />

    <div class="flex justify-end">
        <Button
            label="Save"
            className="px-12.5 h-input mt-6"
            onclick={() => form.put(resourceRoute({ current_team: currentTeamSlug, project: projectId, resource: projectResource!.id }).url, {
                onSuccess: onclose,
            })}
            spinner={form.processing}
        />
    </div>
</Dialog>
