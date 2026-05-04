<script lang="ts">
    import { Button } from "bits-ui";
    import Spinner from "./spinner.svelte";
    import type { Snippet } from "svelte";
    import type { LucideIcon } from "@lucide/svelte";

    type Kind = 'primary' | 'secondary' | 'danger';

    let {
        label,
        onclick,
        icon,
        spinner = false,
        children,
        kind = 'primary',
        className = '',
    }: {
        label?: string,
        onclick?: () => void,
        icon?: LucideIcon,
        spinner?: boolean,
        children?: Snippet,
        kind?: Kind,
        className?: string,
    } = $props();

    function getColorsByKind(kind: Kind): string|void {
        if (kind === 'primary') {
            return 'bg-dark text-background hover:bg-dark/95';
        } else if (kind === 'secondary') {
            return 'bg-muted hover:bg-dark-10';
        } else if (kind === 'danger') {
            return 'bg-danger text-danger-foreground hover:bg-dark-10';
        }
    }
</script>

<Button.Root
    class="rounded-input {getColorsByKind(kind)} shadow-mini inline-flex h-input
        h-12 items-center justify-center px-5.25 text-[15px] cursor-pointer
        font-semibold active:scale-[0.98] active:transition-all relative {className}"
    {onclick}
>
    <div class="inline-flex gap-2 items-center" class:opacity-0={spinner}>
        {#if children}
            {@render children()}
        {:else}
            {#if icon}
                {@const Icon = icon}
                <Icon size="20" />
            {/if}
            {label}
        {/if}
    </div>

    {#if spinner}
        <div class="absolute inset-0 flex items-center justify-center">
            <Spinner
                white={kind === 'danger'}
            />
        </div>
    {/if}
</Button.Root>
