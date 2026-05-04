<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { Label } from "bits-ui";
    import type { Project, ProjectResource, ProjectResourceApplicationPort } from "@/types";
    import Dialog from "@/components/ui/dialog.svelte";
    import Input from "@/components/ui/input.svelte";
    import Button from "@/components/ui/button.svelte";
    import { ports as portsRoute } from '@/routes/project/resource/application';

    let {
        port,
        resourceId,
        projectId,
        currentTeamSlug,
        open,
        onclose,
    }: {
        port: ProjectResourceApplicationPort|null
        resourceId: number,
        projectId: number,
        currentTeamSlug: string,
        open: boolean,
        onclose: () => void,
    } = $props();

    const form = useForm({
        selector: '',
        hostPort: '',
        containerPort: '',
    });

    $effect(() => {
        if (open && port) {
            form.selector = port.selector!;
            form.hostPort = port.hostPort;
            form.containerPort = port.containerPort;
        }
    });
</script>

<Dialog
    title="Edit Port"
    {open}
    {onclose}
>
    <Label.Root for="hostport">Host Port</Label.Root>
    <Input
        id="hostport"
        placeholder="54320"
        bind:value={form.hostPort}
    />

    {#if form.errors.hostPort}
        <p class="text-red-500 text-sm mt-2">{form.errors.hostPort}</p>
    {/if}

    <div class="mt-3"></div>
    <Label.Root for="containerport">Container Port</Label.Root>
    <Input
        id="containerport"
        placeholder="5432"
        bind:value={form.containerPort}
    />

    {#if form.errors.containerPort}
        <p class="text-red-500 text-sm mt-2">{form.errors.containerPort}</p>
    {/if}

    <div class="flex justify-end mt-6">
        <Button
            label="Save"
            className="px-12.5 h-input"
            onclick={() => form.put(portsRoute({ current_team: currentTeamSlug, project: projectId, resource: resourceId }).url, {
                onSuccess: onclose,
            })}
            spinner={form.processing}
        />
    </div>
</Dialog>
