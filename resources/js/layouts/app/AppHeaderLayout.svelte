<script lang="ts">
    import type { BreadcrumbItem } from '@/types';

    let {
        breadcrumbs = [],
    }: {
        breadcrumbs?: BreadcrumbItem[];
    } = $props();
</script>

<div class="h-14 border-b border-b-border">
    {#each breadcrumbs as breadcrumb}
        <p>{breadcrumb.title}</p>
    {/each}
</div>
