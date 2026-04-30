<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { AlertDialog as BitsAlertDialog } from "bits-ui";
    import { resource as resourceRoute } from "@/routes/project";
    import type { ProjectResource } from "@/types";
    import AlertDialog from "../ui/alertDialog.svelte";
    import Button from "../ui/button.svelte";

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

    const form = useForm();

    function submit() {
        if (!projectResource) {
            return;
        }

        form.delete(resourceRoute({ current_team: currentTeamSlug, project: projectId, resource: projectResource.id }).url, {
            onSuccess: onclose,
        });
    }
</script>

<AlertDialog
    title="Delete Project Resource"
    {open}
    {onclose}
>
    <BitsAlertDialog.Description class="text-foreground-alt text-sm">
        This action cannot be undone. This will delete project resource "{projectResource?.name}".
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
