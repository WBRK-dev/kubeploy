<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { Label } from "bits-ui";
    import { project as projectRoute } from '@/routes';
    import { ProjectResourceType } from "@/types";
    import type { SelectItem } from "@/types/components/ui/select";
    import Button from "../ui/button.svelte";
    import Dialog from "../ui/dialog.svelte";
    import Input from "../ui/input.svelte";
    import Select from "../ui/select.svelte";

    let {
        projectId,
        currentTeamSlug,
        open,
        onclose,
    }: {
        projectId: number,
        currentTeamSlug: string,
        open: boolean,
        onclose: () => void,
    } = $props();

    const form = useForm({
        name: '',
        type: '',
    });

    const resourceTypes: SelectItem[] = [
        { label: 'Application', value: ProjectResourceType.Application },
        { label: 'Yaml', value: ProjectResourceType.Yaml },
    ];
</script>

<Dialog
    title="Create Resource"
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
    <Label.Root for="name">Type</Label.Root>
    <Select
        items={resourceTypes}
        bind:value={form.type}
        placeholder="Select resource type"
    />

    {#if form.errors.type}
        <p class="text-red-500 text-sm mt-2">{form.errors.type}</p>
    {/if}

    <div class="flex justify-end mt-6">
        <Button
            label="Save"
            className="px-12.5 h-input"
            onclick={() => form.post(projectRoute({ current_team: currentTeamSlug, project: projectId }).url, {
                onSuccess: onclose,
            })}
            spinner={form.processing}
        />
    </div>
</Dialog>
