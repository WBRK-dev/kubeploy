<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import { Label } from "bits-ui";
    import Button from "@/components/ui/button.svelte";
    import Input from "@/components/ui/input.svelte";
    import Select from "@/components/ui/select.svelte";
    import ApplicationType from "@/lib/enums/applicationType";
    import ImagePullPolicy from "@/lib/enums/imagePullPolicy";
    import { application as applicationRoute } from "@/routes/project/resource";
    import type { ProjectResource } from "@/types";

    let {
        resource,
        projectId,
        currentTeamSlug,
    }: {
        resource: ProjectResource,
        projectId: number,
        currentTeamSlug: string,
    } = $props();

    const form = useForm({
        deployment: { type: ApplicationType.Docker, image: '', imagePullPolicy: '' }
    });

    $effect(() => {
        if (resource.application_trait!.deployment.type === ApplicationType.Docker) {
            form.deployment.image = resource.application_trait!.deployment.image || '';
            form.deployment.imagePullPolicy = resource.application_trait!.deployment.imagePullPolicy || '';
        }
    });
</script>

<Label.Root for="docker-image">Image</Label.Root>
<Input
    placeholder="debian:13"
    bind:value={form.deployment.image}
/>

<div class="mt-2"></div>
<Label.Root>Pull Policy</Label.Root>
<Select
    items={[
        { label: ImagePullPolicy.IfNotPresent, value: ImagePullPolicy.IfNotPresent },
        { label: ImagePullPolicy.Never, value: ImagePullPolicy.Never },
        { label: ImagePullPolicy.Always, value: ImagePullPolicy.Always },
    ]}
    placeholder="Select image pull policy"
    bind:value={form.deployment.imagePullPolicy}
/>

<Button
    label="Save"
    onclick={() => form.put(applicationRoute({ current_team: currentTeamSlug, project: projectId, resource: resource.id }).url)}
    spinner={form.processing}
    className="mt-3"
/>
