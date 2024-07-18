<script setup>
import { ref } from 'vue';


const count = ref(0);
function increment(){
    count.value++;
}
</script>
<template>
    <button class="bg-red-600 p-4" @click="increment">
        {{ count }}
    </button>
</template>