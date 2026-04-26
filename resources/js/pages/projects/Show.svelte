<script lang="ts">
    import type { Project } from "@/types";

    let {
        project,
    }: {
        project: Project,
    } = $props();
</script>

<h3 class="font-semibold text-xl mb-3">Project ({project.name})</h3>
