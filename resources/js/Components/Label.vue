<script setup lang="ts">
defineProps<{
     value?: string
}>();
</script>
<template>
     <label class="pt-3" for="">
          <span v-if="value">{{ value }}</span>
          <!-- <span v-if="value">{{ value }}</span>
          <span v-else>
               <slot />
          </span> -->
     </label>
</template>
