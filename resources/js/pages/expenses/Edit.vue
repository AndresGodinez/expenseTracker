<script setup lang="ts">
import AppShell from '@/components/AppShell.vue'
import Heading from '@/components/Heading.vue'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Checkbox } from '@/components/ui/checkbox'
import { Form, Head, Link } from '@inertiajs/vue3'

type Option = {
    id: number
    name: string
}

type Expense = {
    id: number
    name: string
    amount: string
    category_id: number | null
    payment_method_id: number | null
    active: boolean
    update_url: string
}

defineProps<{
    expense: Expense
    index_url: string
    categories: Option[]
    payment_methods: Option[]
}>()
</script>

<template>
    <AppShell>
        <Head title="Edit expense" />

        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Edit expense" description="Update the expense" />

                <Link :href="index_url" as="button">
                    <Button variant="secondary" size="sm">Back</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card p-4">
                <Form :action="expense.update_url" method="put" class="space-y-4" v-slot="{ errors, processing }">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            name="name"
                            :default-value="expense.name"
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
                            :default-value="expense.amount"
                        />
                        <InputError :message="errors.amount" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="category_id">Category</Label>
                        <select
                            id="category_id"
                            name="category_id"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                            :value="expense.category_id ?? ''"
                        >
                            <option value="">None</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                        <InputError :message="errors.category_id" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="payment_method_id">Payment method</Label>
                        <select
                            id="payment_method_id"
                            name="payment_method_id"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                            :value="expense.payment_method_id ?? ''"
                        >
                            <option value="">None</option>
                            <option v-for="pm in payment_methods" :key="pm.id" :value="pm.id">{{ pm.name }}</option>
                        </select>
                        <InputError :message="errors.payment_method_id" />
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox id="active" name="active" :default-checked="expense.active" />
                        <Label for="active">Active</Label>
                        <InputError :message="errors.active" />
                    </div>

                    <div class="flex items-center gap-2">
                        <Button type="submit" :disabled="processing">Save</Button>
                    </div>
                </Form>
            </div>
        </div>
    </AppShell>
</template>
