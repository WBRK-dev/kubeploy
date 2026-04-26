<script lang="ts">
    let {
        value = $bindable(),
        placeholder,
        name,
        spellcheck = true,
        resize,
        className,
    }: {
        value?: string,
        placeholder?: string,
        name?: string,
        spellcheck?: boolean,
        resize?: 'none' | 'x' | 'y',
        className?: string,
    } = $props();

    function resizeToClass(resize?: string): string {
        if (!resize) {
            return "resize";
        } else if (resize === "none") {
            return "resize-none";
        } else {
            return `resize-${resize}`;
        }
    }
</script>

<textarea
    class="h-input rounded-input border-border-input bg-background text-foreground
        focus:border-border-input-hover focus:outline-4 focus:outline-input-ring
        hover:border-border-input-hover data-invalid:border-destructive flex w-full
        select-none items-center border px-4 py-3 text-sm tracking-[0.01em] {resizeToClass(resize)}
        {className}"
    {placeholder}
    {name}
    {spellcheck}
    bind:value
></textarea>
