import type { Snippet } from "svelte";

export type DataTableColumn = {
    key: string,
    label: string,
    render?: Snippet<Record<string, any>>,
};
