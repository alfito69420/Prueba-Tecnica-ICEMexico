<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue';
import { Certificate, type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import { ref, watch, computed } from 'vue';
import { Pencil, Trash, CirclePlus, FilePenLine } from 'lucide-vue-next';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

interface CertificatesPageProps extends SharedData {
    certificates: Certificate[];
}

const { props } = usePage<CertificatesPageProps>();
const certificates = computed(() => props.certificates);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Certificates',
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

//  metodo enroll certificate
const enrollCertificate = (certificateId: number) => {
    router.post(`/certificates/${certificateId}/enroll`, {}, {
        onSuccess: () => {
            alert('Inscripción realizada correctamente.');
            // Opcional: notificar al usuario o actualizar el estado de la vista
            console.log('Inscripción realizada.');
        },
        onError: (errors) => {
            alert('Hubo un error al realizar la inscripción.');
            console.error('Error al inscribir: ', errors);
        },
    });
};

</script>

<template>

    <head title="Certificates" />
    <AppLayout :breadcrumbs="breadcrumbs">


        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <div class="flex">
                <Button as-child size="lg" class="bg-blue-500 text-white hover:bg-blue-700">
                    <Link :href="`/certificates/create`">
                    <CirclePlus /> Create a new certificate
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
                                    <FilePenLine />
                                    </Link>
                                </Button>

                                <Button size="sm" class="bg-rose-700 text-white hover:bg-rose-700"
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