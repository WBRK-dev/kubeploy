<script lang="ts">
    import { X } from "@lucide/svelte";
    import { Dialog, Separator } from "bits-ui";
    import type { Snippet } from "svelte";

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

<Dialog.Root
    {open}
    onOpenChangeComplete={onclose}
>
    <Dialog.Portal>
        <Dialog.Overlay
            class="data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0
                    data-[state=open]:fade-in-0 fixed inset-0 z-50 bg-black/80"
        />
        <Dialog.Content
            class="rounded-card-lg bg-background shadow-popover data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 outline-hidden fixed left-[50%] top-[50%] z-50 w-full max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] border p-5 sm:max-w-[490px] md:w-full"
        >
            <Dialog.Title
                class="flex w-full items-center justify-center text-lg font-semibold tracking-tight"
            >
                {title}
            </Dialog.Title>
            <Separator.Root class="bg-muted -mx-5 mb-6 mt-5 block h-px" />
            {@render children()}
            <Dialog.Close
                class="focus-visible:ring-foreground focus-visible:ring-offset-background focus-visible:outline-hidden
                    absolute right-6 top-6 rounded-md focus-visible:ring-2 focus-visible:ring-offset-2 active:scale-[0.98]"
            >
                <div>
                    <X class="text-foreground size-5" />
                    <span class="sr-only">Close</span>
                </div>
            </Dialog.Close>
        </Dialog.Content>
    </Dialog.Portal>
</Dialog.Root>
