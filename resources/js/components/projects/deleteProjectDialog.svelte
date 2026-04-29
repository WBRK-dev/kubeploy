<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { AlertDialog as BitsAlertDialog } from "bits-ui";
    import { project as projectRoute } from "@/routes";
    import type { Project } from "@/types";
    import AlertDialog from "../ui/alertDialog.svelte";
    import Button from "../ui/button.svelte";

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

    const form = useForm();

    function submit() {
        if (!project) {
            return;
        }

        form.delete(projectRoute({ current_team: currentTeamSlug, project: project.id }).url, {
            onSuccess: onclose,
        });
    }
</script>

<AlertDialog
    title="Delete Project"
    {open}
    {onclose}
>
    <BitsAlertDialog.Description class="text-foreground-alt text-sm">
        This action cannot be undone. This will delete project "{project?.name}".
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
