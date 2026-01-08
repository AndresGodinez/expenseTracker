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

type Income = {
    id: number;
    name: string;
    amount: string;
    category_income_id: number;
    account_id: number;
    update_url: string;
};

defineProps<{
    income: Income;
    index_url: string;
    category_incomes: Option[];
    accounts: Option[];
}>();
</script>

<template>
    <AppShell>
        <Head title="Edit income" />

        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading
                    title="Edit income"
                    description="Update the income name"
                />

                <Link :href="index_url" as="button">
                    <Button variant="secondary" size="sm">Back</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card p-4">
                <Form
                    :action="income.update_url"
                    method="put"
                    class="space-y-4"
                    v-slot="{ errors, processing }"
                >
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            name="name"
                            :value="income.name"
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
                            :value="income.amount"
                        />
                        <InputError :message="errors.amount" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="category_income_id">Category income</Label>
                        <select
                            id="category_income_id"
                            name="category_income_id"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                            :value="income.category_income_id"
                            required
                        >
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
                            :value="income.account_id"
                            required
                        >
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
                            >Save</Button
                        >
                    </div>
                </Form>
            </div>
        </div>
    </AppShell>
</template>
