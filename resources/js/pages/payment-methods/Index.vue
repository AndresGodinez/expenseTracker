<script setup lang="ts">
import AppShell from '@/components/AppShell.vue'
import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
import { Link } from '@inertiajs/vue3'

type PaymentMethod = {
    id: number
    name: string
    active: boolean
    edit_url: string
    destroy_url: string
}

defineProps<{
    payment_methods: PaymentMethod[]
    create_url: string
}>()
</script>

<template>
    <AppShell>
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Payment methods" description="Manage your payment methods" />

                <Link :href="create_url" as="button">
                    <Button size="sm">Create</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card">
                <div class="border-b px-4 py-3 text-sm font-medium">Registered payment methods</div>

                <div
                    v-if="payment_methods.length === 0"
                    class="px-4 py-6 text-sm text-muted-foreground"
                >
                    No payment methods yet.
                </div>

                <ul v-else class="divide-y">
                    <li
                        v-for="paymentMethod in payment_methods"
                        :key="paymentMethod.id"
                        class="flex items-center justify-between gap-4 px-4 py-3"
                    >
                        <div class="flex items-center gap-3">
                            <span>{{ paymentMethod.name }}</span>
                            <span
                                class="rounded-md border px-2 py-0.5 text-xs"
                                :class="paymentMethod.active ? 'bg-green-50 text-green-700' : 'bg-neutral-50 text-neutral-600'"
                            >
                                {{ paymentMethod.active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <Link :href="paymentMethod.edit_url" as="button">
                                <Button variant="secondary" size="sm">Edit</Button>
                            </Link>

                            <Link :href="paymentMethod.destroy_url" method="delete" as="button">
                                <Button variant="destructive" size="sm">Delete</Button>
                            </Link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppShell>
</template>
