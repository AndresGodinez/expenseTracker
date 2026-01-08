<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form, Head, Link } from '@inertiajs/vue3';

type PaymentMethod = {
    id: number;
    name: string;
    active: boolean;
    update_url: string;
};

defineProps<{
    payment_method: PaymentMethod;
    index_url: string;
}>();
</script>

<template>
    <AppShell>
        <Head title="Edit payment method" />

        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading
                    title="Edit payment method"
                    description="Update the payment method"
                />

                <Link :href="index_url" as="button">
                    <Button variant="secondary" size="sm">Back</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card p-4">
                <Form
                    :action="payment_method.update_url"
                    method="put"
                    class="space-y-4"
                    v-slot="{ errors, processing }"
                >
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            name="name"
                            :default-value="payment_method.name"
                            required
                            maxlength="29"
                            placeholder="Payment method name"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox
                            id="active"
                            name="active"
                            :default-checked="payment_method.active"
                        />
                        <Label for="active">Active</Label>
                        <InputError :message="errors.active" />
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
