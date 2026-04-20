<script lang="ts">
    import type { Snippet } from 'svelte';
    import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.svelte';
    import type { BreadcrumbItem } from '@/types';
    import AppHeaderLayout from './app/AppHeaderLayout.svelte';

    let {
        breadcrumbs = [],
        children,
    }: {
        breadcrumbs?: BreadcrumbItem[];
        children?: Snippet;
    } = $props();
</script>

<div
    class="grid grid-cols-[20rem_1fr] grid-rows-[1fr] h-screen"
>
    <AppSidebarLayout />
    <div class="h-full overflow-auto">
        <AppHeaderLayout {breadcrumbs} />
        <div class="p-4">
            {@render children?.()}
        </div>
    </div>
</div>
