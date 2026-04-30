<script lang="ts">
    import type { SelectItem } from "@/types/components/ui/select";
    import { Check, ChevronDown, ChevronsDown, ChevronsUp } from "@lucide/svelte";
    import { Select } from "bits-ui";

    let {
        type = 'single',
        items,
        placeholder,
        allowDeselect = true,
        onValueChange,
        value = $bindable(),
    }: {
        type?: "single" | "multiple",
        items?: SelectItem[],
        placeholder?: string,
        allowDeselect?: boolean,
        onValueChange?: (value: string[]) => void,
        value?: string | string[]
    } = $props();
</script>

<Select.Root
    {type}
    items={items as { value: string; label: string; disabled?: boolean | undefined; }[]}
    {allowDeselect}
    {onValueChange}
    bind:value
>
    <Select.Trigger
        class="h-input rounded-input border-border-input bg-background data-placeholder:text-foreground-alt/50
            inline-flex touch-none select-none items-center border px-2.75 text-sm transition-colors w-full"
        aria-label={placeholder}
    >
        <Select.Value {placeholder} />
        <ChevronDown class="text-muted-foreground ml-auto size-6" />
    </Select.Trigger>
    <Select.Portal>
        <Select.Content
        class="focus-override border-muted bg-background shadow-popover data-[state=open]:animate-in
            data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0
            data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[side=bottom]:slide-in-from-top-2
            data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2
            data-[side=top]:slide-in-from-bottom-2 outline-hidden z-50 max-h-(--bits-select-content-available-height,24rem)
            w-(--bits-select-anchor-width) min-w-(--bits-select-anchor-width) select-none rounded-xl
            border px-1 py-3 data-[side=bottom]:translate-y-1 data-[side=left]:-translate-x-1 data-[side=right]:translate-x-1
            data-[side=top]:-translate-y-1"
        sideOffset={10}
        >
            <Select.ScrollUpButton class="flex w-full items-center justify-center">
                <ChevronsDown class="size-3" />
            </Select.ScrollUpButton>
            <Select.Viewport class="p-1 min-h-0">
                {#each items as item, i (i + item.value)}
                    <Select.Item
                        class="rounded-button data-highlighted:bg-muted outline-hidden data-disabled:opacity-50 flex h-10 w-full
                            select-none items-center py-3 pl-5 pr-1.5 text-sm capitalize"
                        value={item.value}
                        label={item.label}
                        disabled={item.disabled}
                    >
                        {#snippet children({ selected })}
                            {item.label}
                            {#if selected}
                                <div class="ml-auto">
                                    <Check aria-label="check" size="17" />
                                </div>
                            {/if}
                        {/snippet}
                    </Select.Item>
                {/each}
            </Select.Viewport>
            <Select.ScrollDownButton class="flex w-full items-center justify-center">
                <ChevronsUp class="size-3" />
            </Select.ScrollDownButton>
        </Select.Content>
    </Select.Portal>
</Select.Root>
