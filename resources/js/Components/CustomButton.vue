<script setup lang="ts">

defineProps<{
    value: string | number;
    onClickFunction: () => void;
    className?: string;
}>()
</script>
<template>

    <button @click="onClickFunction" :class="className">
           {{ value }}
    </button>
</template>