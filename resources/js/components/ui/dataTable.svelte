<script lang="ts">
    import type { DataTableColumn } from "@/types/components/ui/dataTable";

    let {
        columns,
        rows,
    }: {
        columns: DataTableColumn[],
        rows: Record<string, any>[],
    } = $props();
</script>

<table class="w-full">
    <thead class="border-b-2 border-border">
        <tr>
            {#each columns as column}
                <th class="px-2 py-1 text-start">{column.label}</th>
            {/each}
        </tr>
    </thead>
    <tbody>
        {#each rows as row}
            <tr class="not-last:border-b border-border">
                {#each columns as column}
                    {#if column.render}
                        <td class="px-2 py-1">{@render column.render(row)}</td>
                    {:else}
                        <td class="px-2 py-1">{row[column.key]}</td>
                    {/if}
                {/each}
            </tr>
        {/each}
    </tbody>
</table>
