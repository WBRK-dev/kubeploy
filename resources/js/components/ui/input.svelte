<script lang="ts">
    let {
        value = $bindable(),
        type = "text",
        placeholder,
        name,
    }: {
        value?: string,
        type?: string,
        placeholder?: string,
        name?: string,
    } = $props();
</script>

<input
    class="h-input rounded-input border-border-input bg-background text-foreground
        focus:border-border-input-hover focus:outline-4 focus:outline-input-ring
        hover:border-border-input-hover data-invalid:border-destructive flex w-full
        select-none items-center border px-2 py-3 text-sm tracking-[0.01em]"
    {type}
    {placeholder}
    {name}
    bind:value
>
