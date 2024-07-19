<script setup lang="ts">
import { onMounted, ref } from 'vue';
const model = defineModel<string>({ required: true })

const inputRef = ref<HTMLInputElement | null>(null);
onMounted(() => {
    if (inputRef?.value?.hasAttribute("autofocus")) {
        inputRef?.value?.focus();
    }
})

</script>


<template>
  <input type="text" class="px-3 py-2 border-gray-300 rounded-md" ref="inputRef" v-model="model">
</template>
