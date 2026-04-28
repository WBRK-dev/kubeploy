<script lang="ts">
    import { CircleStop, RefreshCw, Rocket } from "@lucide/svelte";
    import Button from "@/components/ui/button.svelte";

    let {
        className = '',
    }: {
        className?: string,
    } = $props();
</script>

<div class="flex gap-4 {className}">
    <Button
        label="Deploy"
        icon={Rocket}
    />
    <Button
        label="Reload"
        icon={RefreshCw}
        kind="secondary"
    />
    <Button
        label="Stop"
        icon={CircleStop}
        kind="secondary"
    />
</div>
