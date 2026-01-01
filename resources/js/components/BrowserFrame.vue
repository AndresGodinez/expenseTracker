<script setup lang="ts">
const props = withDefaults(
    defineProps<{
        url?: string;
        class?: string;
    }>(),
    {
        url: 'app.carvaz.com',
        class: '',
    },
);
</script>

<template>
    <div
        :class="[
            'overflow-hidden rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur',
            props.class,
        ]"
    >
        <div class="flex items-center justify-between border-b border-slate-200 bg-slate-100/70 px-3 py-2">
            <div class="flex items-center gap-1.5">
                <span class="h-2.5 w-2.5 rounded-full bg-red-400" />
                <span class="h-2.5 w-2.5 rounded-full bg-amber-400" />
                <span class="h-2.5 w-2.5 rounded-full bg-green-400" />
            </div>
            <div class="mx-3 flex-1">
                <div class="truncate rounded-md border border-slate-200 bg-white/70 px-3 py-1 text-xs text-slate-700">
                    {{ url }}
                </div>
            </div>
            <div class="w-10" />
        </div>

        <div class="bg-white/70">
            <slot />
        </div>
    </div>
</template>
