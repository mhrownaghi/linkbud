<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    description: '',
    slug: '',
    links: [
        {
            name: '',
            url: '',
            order: '1'
        }
    ],
});

function submit() {    
    form.post(route('link-lists.store'));
}

</script>
<template>
    <Head title="Create Link Lists" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Link List</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Link List Information</h2>

                            <p class="mt-1 text-sm text-gray-600">Enter your link list informations</p>
                        </header>
                        <form class="mt-6 space-y-6" @submit.prevent="submit()">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="description" value="Description" />
                                <TextInput
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                />
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>
                            <div>
                                <InputLabel for="slug" value="Slug" />
                                <TextInput
                                    id="slug"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.slug"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.slug" />
                            </div>
                            <h3 class="text-md font-medium text-gray-800">Links</h3>
                            <div>
                                <div v-for="(link, index) in form.links" :key="index" class="space-y-6 mt-4 border border-gray-300 p-4 rounded">
                                    <div>
                                        <InputLabel for="name" value="Name" />
                                        <TextInput
                                            id="name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.links[index].name"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors['links.' + index + '.name']" />
                                    </div>
                                    <div>
                                        <InputLabel for="url" value="URL" />
                                        <TextInput
                                            id="url"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.links[index].url"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors['links.' + index + '.url']" />
                                    </div>
                                    <div>
                                        <InputLabel for="order" value="Order" />
                                        <TextInput
                                            id="order"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="form.links[index].order"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors['links.' + index + '.order']" />
                                    </div>
                                    <div>
                                        <SecondaryButton @click="form.links.splice(index, 1)" class="text-red-500">
                                            Remove
                                        </SecondaryButton>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <SecondaryButton @click="form.links.push({ name: '', url: '', order: '1' })">Add Link</SecondaryButton>
                            </div>
                            <div>
                                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>