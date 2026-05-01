<script lang="ts">
    import { Tabs } from "bits-ui";
    import type { Component } from "svelte";


    let {
        value = $bindable(''),
        items,
    }: {
        value?: string,
        items: {
            label: string,
            value: string,
            content: {
                component: Component<any>,
                props?: Record<string, any>,
            },
        }[],
    } = $props();
</script>

<Tabs.Root
    bind:value
    class="w-full"
>
    <Tabs.List
        class="rounded-xl bg-dark-10 shadow-mini-inset dark:bg-background flex flex-wrap
            gap-1 p-1 text-sm font-semibold leading-[0.01em] dark:border w-max
            dark:border-neutral-600/30"
    >
        {#each items as item}
            <Tabs.Trigger
                value={item.value}
                class="data-[state=active]:shadow-mini dark:data-[state=active]:bg-muted h-8
                    rounded-[7px] bg-transparent px-8 py-2 data-[state=active]:bg-white cursor-pointer"
            >
                {item.label}
            </Tabs.Trigger>
        {/each}
    </Tabs.List>
    {#each items as item}
        <Tabs.Content value={item.value} class="select-none pt-3">
            <item.content.component {...item.content.props} />
        </Tabs.Content>
    {/each}
</Tabs.Root>
