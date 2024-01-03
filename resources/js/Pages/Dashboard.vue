<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Главная страница" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Главная страница</h2>
        </template>

        <div class="">
            <div class="">
                <div class="">
                    <div class="">Вы вошли!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
