<script setup lang="ts">
import AppShell from '@/components/AppShell.vue'
import Heading from '@/components/Heading.vue'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Form, Head, Link } from '@inertiajs/vue3'

defineProps<{
    store_url: string
    index_url: string
}>()
</script>

<template>
    <AppShell>
        <Head title="Create income category" />

        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Create income category" description="Add a new income category" />

                <Link :href="index_url" as="button">
                    <Button variant="secondary" size="sm">Back</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card p-4">
                <Form :action="store_url" method="post" class="space-y-4" v-slot="{ errors, processing }">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" name="name" required maxlength="29" placeholder="Income category name" />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="flex items-center gap-2">
                        <Button type="submit" :disabled="processing">Create</Button>
                    </div>
                </Form>
            </div>
        </div>
    </AppShell>
</template>
