<script lang="ts">
    import Button from "@/components/ui/button.svelte";
    import type { Project, ProjectResource } from "@/types";
    import YamlInput from "./yaml/yamlInput.svelte";

    let {
        project,
        resource,
    }: {
        project: Project,
        resource: ProjectResource,
    } = $props();
</script>

<YamlInput
    bind:yaml={resource.yaml_trait!.yaml}
/>

<Button
    label="Save"

/>
