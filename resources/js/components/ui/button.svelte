<script lang="ts">
    import { Button } from "bits-ui";
    import Spinner from "./spinner.svelte";
    // import { Snippet } from "svelte";

    let {
        label,
        onclick,
        spinner = false,
        // children,
    }: {
        label?: string,
        onclick?: () => void,
        spinner?: boolean,
        // children?: Snippet,
    } = $props();
</script>

<Button.Root
    class="rounded-input bg-dark text-background shadow-mini hover:bg-dark/95 inline-flex
        h-12 items-center justify-center px-[21px] text-[15px] cursor-pointer
        font-semibold active:scale-[0.98] active:transition-all relative"
    {onclick}
>
    <div class:opacity-0={spinner}>
        <!-- {#if children}
            {@render children()}
        {:else} -->
            {label}
        <!-- {/if} -->
    </div>

    {#if spinner}
        <div class="absolute inset-0 flex items-center justify-center">
            <Spinner/>
        </div>
    {/if}
</Button.Root>
