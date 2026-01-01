<script setup lang="ts">
import AppShell from '@/components/AppShell.vue'
import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
import { Link } from '@inertiajs/vue3'

type Account = {
    id: number
    name: string
    edit_url: string
    destroy_url: string
}

defineProps<{
    accounts: Account[]
    create_url: string
}>()
</script>

<template>
    <AppShell>
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Accounts" description="Manage your accounts" />

                <Link :href="create_url" as="button">
                    <Button size="sm">Create</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card">
                <div class="border-b px-4 py-3 text-sm font-medium">Registered accounts</div>

                <div v-if="accounts.length === 0" class="px-4 py-6 text-sm text-muted-foreground">No accounts yet.</div>

                <ul v-else class="divide-y">
                    <li v-for="account in accounts" :key="account.id" class="flex items-center justify-between gap-4 px-4 py-3">
                        <span>{{ account.name }}</span>

                        <div class="flex items-center gap-2">
                            <Link :href="account.edit_url" as="button">
                                <Button variant="secondary" size="sm">Edit</Button>
                            </Link>

                            <Link :href="account.destroy_url" method="delete" as="button">
                                <Button variant="destructive" size="sm">Delete</Button>
                            </Link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppShell>
</template>
