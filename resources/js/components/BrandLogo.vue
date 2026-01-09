<script setup lang="ts">
</script>

<template>
    <svg
        width="220"
        height="48"
        viewBox="0 0 220 48"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        role="img"
        aria-label="Carvaz"
    >
        <defs>
            <linearGradient
                id="g"
                x1="0"
                y1="0"
                x2="48"
                y2="48"
                gradientUnits="userSpaceOnUse"
            >
                <stop stop-color="#2563EB" />
                <stop offset="1" stop-color="#1D4ED8" />
            </linearGradient>
        </defs>

        <rect x="2" y="2" width="44" height="44" rx="12" fill="url(#g)" />

        <path
            d="M33 16.5C31.3 14.6 28.9 13.5 26.2 13.5C21.1 13.5 17 17.6 17 22.7C17 27.8 21.1 31.9 26.2 31.9C28.9 31.9 31.3 30.8 33 28.9"
            stroke="white"
            stroke-width="3.2"
            stroke-linecap="round"
        />

        <path
            d="M18 28.8L22.2 24.6L25.2 27.6L30.5 22.3L34 25.8"
            stroke="white"
            stroke-width="2.6"
            stroke-linecap="round"
            stroke-linejoin="round"
        />

        <text
            x="58"
            y="30"
            font-family="Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial"
            font-size="18"
            font-weight="700"
            fill="#0F172A"
        >
            Carvaz
        </text>
        <text
            x="120"
            y="30"
            font-family="Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial"
            font-size="18"
            font-weight="600"
            fill="#2563EB"
        >
            ExpenseTracker
        </text>
    </svg>
</template>
