<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form, Head, Link } from '@inertiajs/vue3';

type Option = {
    id: number;
    name: string;
};

defineProps<{
    store_url: string;
    index_url: string;
    categories: Option[];
    payment_methods: Option[];
}>();
</script>

<template>
    <AppShell>
        <Head title="Create expense" />

        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading
                    title="Create expense"
                    description="Add a new expense"
                />

                <Link :href="index_url" as="button">
                    <Button variant="secondary" size="sm">Back</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card p-4">
                <Form
                    :action="store_url"
                    method="post"
                    class="space-y-4"
                    v-slot="{ errors, processing }"
                >
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            name="name"
                            required
                            maxlength="29"
                            placeholder="Expense name"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="amount">Amount</Label>
                        <Input
                            id="amount"
                            name="amount"
                            required
                            type="number"
                            step="0.01"
                            min="0"
                            max="999999.99"
                        />
                        <InputError :message="errors.amount" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="category_id">Category</Label>
                        <select
                            id="category_id"
                            name="category_id"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                        >
                            <option value="">None</option>
                            <option
                                v-for="c in categories"
                                :key="c.id"
                                :value="c.id"
                            >
                                {{ c.name }}
                            </option>
                        </select>
                        <InputError :message="errors.category_id" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="payment_method_id">Payment method</Label>
                        <select
                            id="payment_method_id"
                            name="payment_method_id"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                        >
                            <option value="">None</option>
                            <option
                                v-for="pm in payment_methods"
                                :key="pm.id"
                                :value="pm.id"
                            >
                                {{ pm.name }}
                            </option>
                        </select>
                        <InputError :message="errors.payment_method_id" />
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox
                            id="active"
                            name="active"
                            :default-checked="true"
                        />
                        <Label for="active">Active</Label>
                        <InputError :message="errors.active" />
                    </div>

                    <div class="flex items-center gap-2">
                        <Button type="submit" :disabled="processing"
                            >Create</Button
                        >
                    </div>
                </Form>
            </div>
        </div>
    </AppShell>
</template>
