<script setup>
import Label from '@/Components/Label.vue';
import { ref } from 'vue';


const count = ref(0);
function increment(){
    count.value++;
}
</script>
<template>
    <Label value="hey"/>
    <button class="p-4 bg-red-600" @click="increment">
        {{ count }}
    </button>
</template>