<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { Label } from "bits-ui";
    import { projects as projectsRoute } from '@/routes';
    import Button from "../ui/button.svelte";
    import Dialog from "../ui/dialog.svelte";
    import Input from "../ui/input.svelte";

    let {
        currentTeamSlug,
        open,
        onclose,
    }: {
        currentTeamSlug: string,
        open: boolean,
        onclose: () => void,
    } = $props();

    const form = useForm({
        name: '',
    });
</script>

<Dialog
    title="Create Project"
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
            onclick={() => form.post(projectsRoute({ current_team: currentTeamSlug }).url, {
                onSuccess: onclose,
            })}
            spinner={form.processing}
        />
    </div>
</Dialog>
