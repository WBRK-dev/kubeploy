<script lang="ts">
    import TextArea from "@/components/ui/textArea.svelte";

    let {
        yaml = $bindable(),
    }: {
        yaml: string,
    } = $props();
</script>

<TextArea
    bind:value={yaml}
    spellcheck={false}
    resize="y"
    className="h-140"
/>
