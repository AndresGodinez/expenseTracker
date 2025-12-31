<script setup lang="ts">
import AppShell from '@/components/AppShell.vue'
import Heading from '@/components/Heading.vue'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Form, Head, Link } from '@inertiajs/vue3'

type Category = {
    id: number
    name: string
    update_url: string
}

defineProps<{
    category: Category
    index_url: string
}>()
</script>

<template>
    <AppShell>
        <Head title="Edit category" />

        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Edit category" description="Update the category name" />

                <Link :href="index_url" as="button">
                    <Button variant="secondary" size="sm">Back</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card p-4">
                <Form
                    :action="category.update_url"
                    method="put"
                    class="space-y-4"
                    v-slot="{ errors, processing }"
                >
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            name="name"
                            :default-value="category.name"
                            required
                            maxlength="100"
                            placeholder="Category name"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="flex items-center gap-2">
                        <Button type="submit" :disabled="processing">Save</Button>
                    </div>
                </Form>
            </div>
        </div>
    </AppShell>
</template>
