<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    import { store } from '@/actions/Laravel/Fortify/Http/Controllers/AuthenticatedSessionController';
    import Button from '@/components/ui/button.svelte';
    import Input from '@/components/ui/input.svelte';

    const form = useForm({
        email: '',
        password: '',
    });

    let submitting = $state(false);
    let errors: Record<string, string> = $state({});

    async function onsubmit(e: SubmitEvent) {
        e.preventDefault();

        submitting = true;

        form.submit(store.post(), {
            onFinish: () => {
                submitting = false;
            },
            onError: (err) => errors = err,
        });
    }
</script>

<div class="flex flex-col items-center py-20">
    <h1 class="font-bold text-4xl mb-8">Kubeploy</h1>
    <form class="w-70 flex flex-col gap-2" {onsubmit}>
        <Input
            placeholder="Email"
            name="email"
            bind:value={form.email}
        />
        {#if errors.email}
            <p class="text-red-500">{errors.email}</p>
        {/if}
        <Input
            placeholder="Password"
            type="password"
            name="password"
            bind:value={form.password}
        />
        {#if errors.password}
            <p class="text-red-500">{errors.password}</p>
        {/if}

        <Button
            label="Login"
            spinner={submitting}
        />
    </form>
</div>
