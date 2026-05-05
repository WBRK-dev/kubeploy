<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { Label } from "bits-ui";
    import Button from "@/components/ui/button.svelte";
    import Dialog from "@/components/ui/dialog.svelte";
    import Input from "@/components/ui/input.svelte";
    import { domains as domainsRoute } from '@/routes/project/resource/application';
    import type { ProjectResourceApplicationDomain } from "@/types";

    let {
        domain,
        resourceId,
        projectId,
        currentTeamSlug,
        open,
        onclose,
    }: {
        domain: ProjectResourceApplicationDomain|null
        resourceId: number,
        projectId: number,
        currentTeamSlug: string,
        open: boolean,
        onclose: () => void,
    } = $props();

    const form = useForm({
        selector: '',
        domain: '',
        containerPort: '',
    });

    $effect(() => {
        if (open && domain) {
            form.selector = domain.selector!;
            form.domain = domain.domain;
            form.containerPort = domain.containerPort;
        }
    });
</script>

<Dialog
    title="Edit Domain"
    {open}
    {onclose}
>
    <Label.Root for="domain">Domain</Label.Root>
    <Input
        id="domain"
        placeholder="pgsql.yourdomain.com"
        bind:value={form.domain}
    />

    {#if form.errors.domain}
        <p class="text-red-500 text-sm mt-2">{form.errors.domain}</p>
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
            onclick={() => form.put(domainsRoute({ current_team: currentTeamSlug, project: projectId, resource: resourceId }).url, {
                onSuccess: onclose,
            })}
            spinner={form.processing}
        />
    </div>
</Dialog>
