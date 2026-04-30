<script lang="ts">
    import { useForm } from "@inertiajs/svelte";
    import Button from "@/components/ui/button.svelte";
    import type { Project, ProjectResource, Team } from "@/types";
    import YamlInput from "./yaml/yamlInput.svelte";
    import { yaml as yamlRoute } from "@/routes/project/resource";

    let {
        project,
        resource,
        currentTeam,
    }: {
        project: Project,
        resource: ProjectResource,
        currentTeam: Team,
    } = $props();

    const form = useForm({
        yaml: resource.yaml_trait!.yaml,
    });

    function save() {
        form.put(yamlRoute({ current_team: currentTeam.slug, project: project.id, resource: resource.id }).url);
    }
</script>

<YamlInput
    bind:yaml={form.yaml}
/>

<Button
    label="Save"
    onclick={save}
    spinner={form.processing}
    className="mt-3"
/>
