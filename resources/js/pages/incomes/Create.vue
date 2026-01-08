<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
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
    category_incomes: Option[];
    accounts: Option[];
}>();
</script>

<template>
    <AppShell>
        <Head title="Create income" />

        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Create income" description="Add a new income" />

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
                            placeholder="Income name"
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
                        <Label for="category_income_id">Category income</Label>
                        <select
                            id="category_income_id"
                            name="category_income_id"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                            required
                        >
                            <option value="" disabled selected>
                                Select a category
                            </option>
                            <option
                                v-for="c in category_incomes"
                                :key="c.id"
                                :value="c.id"
                            >
                                {{ c.name }}
                            </option>
                        </select>
                        <InputError :message="errors.category_income_id" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="account_id">Account</Label>
                        <select
                            id="account_id"
                            name="account_id"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                            required
                        >
                            <option value="" disabled selected>
                                Select an account
                            </option>
                            <option
                                v-for="a in accounts"
                                :key="a.id"
                                :value="a.id"
                            >
                                {{ a.name }}
                            </option>
                        </select>
                        <InputError :message="errors.account_id" />
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
