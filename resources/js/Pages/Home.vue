<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

const logout = () => {
    router.post(route("logout"), {

    }, {
        onSuccess: () => {
            router.post(route("login"))
        }
    })
}
</script>

<template>
    <!-- <AuthenticatedLayout> -->
    <h1>Hello This is home</h1>
    <button @click="logout">Logout</button>
    <!-- </AuthenticatedLayout> -->
</template>