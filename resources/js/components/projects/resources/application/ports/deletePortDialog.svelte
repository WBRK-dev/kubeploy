<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { AlertDialog as BitsAlertDialog } from "bits-ui";
    import { ports as portsRoute } from "@/routes/project/resource/application";
    import type { ProjectResourceApplicationPort } from "@/types";
    import AlertDialog from "@/components/ui/alertDialog.svelte";
    import Button from "@/components/ui/button.svelte";

    let {
        port,
        resourceId,
        projectId,
        currentTeamSlug,
        open,
        onclose,
    }: {
        port: ProjectResourceApplicationPort|null,
        resourceId: number,
        projectId: number,
        currentTeamSlug: string,
        open: boolean,
        onclose: () => void,
    } = $props();

    const form = useForm({
        selector: '',
    });

    function submit() {
        if (port === null) {
            return;
        }

        form.selector = port.selector!;

        form.delete(portsRoute({ current_team: currentTeamSlug, project: projectId, resource: resourceId }).url, {
            onSuccess: onclose,
        });
    }
</script>

<AlertDialog
    title="Delete Port"
    {open}
    {onclose}
>
    <BitsAlertDialog.Description class="text-foreground-alt text-sm">
        This action cannot be undone. This will delete port "{port?.hostPort}:{port?.containerPort}".
        Do you wish to continue?
    </BitsAlertDialog.Description>
    <div class="flex w-full items-center justify-center gap-2">
        <Button
            label="Cancel"
            kind="secondary"
            className="h-input w-full"
            onclick={onclose}
        />
        <Button
            label="Continue"
            kind="danger"
            className="h-input w-full"
            onclick={submit}
            spinner={form.processing}
        />
    </div>
</AlertDialog>
