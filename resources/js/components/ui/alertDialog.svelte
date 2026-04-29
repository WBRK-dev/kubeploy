<script lang="ts">
    import { AlertDialog } from "bits-ui";

    let {
        title,
        children,
        open,
        onclose,
    }: {
        title: string,
        children: Snippet,
        open: boolean,
        onclose: () => void,
    } = $props();
</script>

<AlertDialog.Root {open} onOpenChangeComplete={onclose}>
    <AlertDialog.Portal>
        <AlertDialog.Overlay
            class="data-[state=open]:animate-in data-[state=closed]:animate-out
                data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 fixed
                inset-0 z-50 bg-black/80"
        />
        <AlertDialog.Content
            class="rounded-card-lg bg-background shadow-popover data-[state=open]:animate-in
                data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0
                data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 outline-hidden fixed
                left-[50%] top-[50%] z-50 grid w-full max-w-[calc(100%-2rem)] translate-x-[-50%]
                translate-y-[-50%] gap-4 border p-7 sm:max-w-lg md:w-full "
        >
            <AlertDialog.Title class="text-lg font-semibold tracking-tight">
                {title}
            </AlertDialog.Title>
            {@render children()}
        </AlertDialog.Content>
    </AlertDialog.Portal>
</AlertDialog.Root>
