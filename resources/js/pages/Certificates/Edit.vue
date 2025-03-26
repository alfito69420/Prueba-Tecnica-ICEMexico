<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import { ref } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Breadcrumb from '@/components/ui/breadcrumb/Breadcrumb.vue';
import { Certificate } from '@/types';

type BreadCrumbItem = {
    title: string;
    href: string;
}

const { props } = usePage();
const certificate = props.certificate as Certificate;

const breadcrumbs: BreadCrumbItem[] = [
    { title: 'Certificates', href: '/certificates' },
    { title: 'Edit', href: '#' },
];

const form = ref<Partial<{ name: string, description: string }>>({
    name: '',
    description: '',
});

onMounted(() => {
    form.value = {
        name: certificate.name ?? '',
        description: certificate.description ?? '',
    };
});

const resetForm = () => {
    form.value = {
        name: '',
        description: '',
    };
}

const submit = () => {
    router.put(`/certificates/${certificate.id}`, form.value, {
        onSuccess: () => {
            resetForm();
        },
        onError: (errors) => {
            console.error('Error editing certificate: ', errors);
        },
    });
}

</script>

<template>

    <head title="Create Certificate" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="text-2xl font-bold">Edit Certificate</h1>

            <form @submit.prevent="submit" class="space-y-6 max-w-lg">
                <div v-for="(label, key) in { name: 'Name', description: 'Description' }" :key="key" class="space-y-2">
                    <Label :for="key">{{ label }}</Label>
                    <Input :id="key" v-model="form[key]" :name="key" :type="key === 'description' ? 'textarea' : 'text'"
                        :placeholder="label" :required="key !== 'name'" />
                </div>
                <div class="flex gap-4">
                    <Button type="submit" class="bg-blue-500 text-white hover:bg-blue-700">Save</Button>
                    <Button as="a" href="/certificates" variant="outline">Cancel</Button>
                </div>
            </form>

        </div>
    </AppLayout>
</template>