<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue';
import { Certificate, type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'

import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';
import { computed } from 'vue';

interface CertificatesPageProps extends SharedData {
    certificates: Certificate[];
}

const { props } = usePage<CertificatesPageProps>();
const certificates = computed(() => props.certificates);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Certificates',
        //href: route('certificates.index'),
        href: '/certificates',
    },
];

//  metodo delete certificate
const deleteCertificate = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this certificate?')) {
        return;
    }

    router.delete(`/certificates/${id}`, {
        preserveScroll: true,
        onSuccess: () => {
            router.visit('/certificates', { replace: true });
        },
        onError: (errors) => {
            console.error('Errror deleting employee: ', errors)
        },
    });
}

</script>


<template>

    <head title="Certificates" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex">
                <Button as-child size="lg" class="bg-blue-500 text-white hover:bg-blue-700">
                    <Link :href="`/certificates/create`">
                    <CirclePlus /> Create
                    </Link>
                </Button>
            </div>


            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">

                <Table>
                    <TableCaption>Certificates List.</TableCaption>
                    <TableHeader>
                        <!-- header -->
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead class="text-center">Actions</TableHead>
                        </TableRow>
                    </TableHeader>

                    <!-- body -->
                    <TableBody>
                        <TableRow v-for="certificate in certificates" :key="certificate.id">
                            <TableCell class="font-medium">{{ certificate.name }}</TableCell>
                            <TableCell>{{ certificate.description ?? 'N/A' }}</TableCell>
                            <TableCell class="flex justify-center gap-2">
                                <Button as-child size="sm" class="bg-blue-500 text-white hover:bg-blue-700">
                                    <Link :href="`/certificates/${certificate.id}/edit`">
                                    <Pencil />
                                    </Link>
                                </Button>

                                <Button size="sm" class="bg-rose-500 text-white hover:bg-rose-700"
                                    @click="deleteCertificate(certificate.id)">
                                    <Trash />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>