<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { AlertDialog as BitsAlertDialog } from "bits-ui";
    import AlertDialog from "@/components/ui/alertDialog.svelte";
    import Button from "@/components/ui/button.svelte";
    import { domains as domainsRoute } from "@/routes/project/resource/application";
    import type { ProjectResourceApplicationDomain } from "@/types";

    let {
        domain,
        resourceId,
        projectId,
        currentTeamSlug,
        open,
        onclose,
    }: {
        domain: ProjectResourceApplicationDomain|null,
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
        if (domain === null) {
            return;
        }

        form.selector = domain.selector!;

        form.delete(domainsRoute({ current_team: currentTeamSlug, project: projectId, resource: resourceId }).url, {
            onSuccess: onclose,
        });
    }
</script>

<AlertDialog
    title="Delete Domain"
    {open}
    {onclose}
>
    <BitsAlertDialog.Description class="text-foreground-alt text-sm">
        This action cannot be undone. This will delete domain "{domain?.domain}".
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
