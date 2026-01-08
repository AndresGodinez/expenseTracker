<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form, Head, Link } from '@inertiajs/vue3';

type Account = {
    id: number;
    name: string;
    update_url: string;
};

defineProps<{
    account: Account;
    index_url: string;
}>();
</script>

<template>
    <AppShell>
        <Head title="Edit account" />

        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading
                    title="Edit account"
                    description="Update the account name"
                />

                <Link :href="index_url" as="button">
                    <Button variant="secondary" size="sm">Back</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card p-4">
                <Form
                    :action="account.update_url"
                    method="put"
                    class="space-y-4"
                    v-slot="{ errors, processing }"
                >
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            name="name"
                            :default-value="account.name"
                            required
                            maxlength="29"
                            placeholder="Account name"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="flex items-center gap-2">
                        <Button type="submit" :disabled="processing"
                            >Save</Button
                        >
                    </div>
                </Form>
            </div>
        </div>
    </AppShell>
</template>
