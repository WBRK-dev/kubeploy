<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { Label } from "bits-ui";
    import { project as projectRoute } from '@/routes';
    import type { Project } from "@/types";
    import Button from "../ui/button.svelte";
    import Dialog from "../ui/dialog.svelte";
    import Input from "../ui/input.svelte";

    let {
        project,
        currentTeamSlug,
        open,
        onclose,
    }: {
        project: Project|null,
        currentTeamSlug: string,
        open: boolean,
        onclose: () => void,
    } = $props();

    const form = useForm({
        name: '',
    });

    $effect(() => {
        if (open && project) {
            form.name = project.name;
        }
    });
</script>

<Dialog
    title="Edit Project"
    {open}
    {onclose}
>
    <Label.Root for="name">Name</Label.Root>

    <Input
        id="name"
        placeholder="My Project"
        bind:value={form.name}
    />

    {#if form.errors.name}
        <p class="text-red-500 text-sm mt-2">{form.errors.name}</p>
    {/if}

    <div class="flex justify-end">
        <Button
            label="Save"
            className="px-12.5 h-input mt-6"
            onclick={() => form.put(projectRoute({ current_team: currentTeamSlug, project: project!.id }).url, {
                onSuccess: onclose,
            })}
            spinner={form.processing}
        />
    </div>
</Dialog>
