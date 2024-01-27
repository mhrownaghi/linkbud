<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

defineProps({
    link: Object
})
</script>

<template>
    <div class="py-4 px-6 text-white font-bold text-xl rounded" :style="`background-color: ${link.color}`">
        <a :href="link.url" target="_blank">
            <FontAwesomeIcon :icon="link.icon" class="mr-2 align-middle" v-if="link.icon"/>
            <span>{{ link.name }}</span>
        </a>
    </div>
</template>