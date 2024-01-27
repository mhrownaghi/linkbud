<script setup>
import UserLink from '@/Components/UserLink.vue';
import { getLink } from '@/link';
import { Head } from '@inertiajs/vue3'

defineProps({
    linkList: Object,
    links: Object
})

function work(link) {
    return getLink(link);
}

</script>

<template>
   <Head :title="linkList.name" />
   <header class="pt-6">
       <h1 class="text-3xl font-bold text-center">{{linkList.name}}</h1>
   </header>
   <main>
        <p class="mt-4 text-center">{{ linkList.description }}</p>
        <ul class="mt-4 flex flex-col items-center gap-8">
            <li v-for="link in links" :key="link.id" class="">
                <UserLink :link="work(link)"/>
            </li>
        </ul>
   </main>
   <footer class="absolute bottom-0 right-auto w-full p-4">
       <p class="text-center text-blue-500">Made with Linkbud</p>
   </footer>
</template>