<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue';
import { Certificate, type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import { ref, watch, computed } from 'vue';
import { Trash } from 'lucide-vue-next';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'MyCertificates',
        //href: route('certificates.index'),
        href: '/my-certificates',
    },
];

interface CertificatesPageProps extends SharedData {
    certificates: Certificate[];
}

const { props } = usePage<CertificatesPageProps>();
const certificates = computed(() => props.certificates);

const unsubscribe = (certificateId: number) => {
    if (confirm('¿Estás seguro de que deseas eliminar tu inscripción?')) {
        router.delete(`/certificates/${certificateId}/unsubscribe`, {
            preserveScroll: true,
            onSuccess: () => {
                alert('Inscripción eliminada correctamente.');
            },
            onError: (errors) => {
                console.error(errors);
                alert('Hubo un error al eliminar la inscripción.');
            }
        });
    }
};

</script>

<template>

    <head title="Certificates" />
    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">

                <Table>
                    <TableCaption>Certificates List.</TableCaption>
                    <TableHeader>
                        <!-- header -->
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-center">Unsubscribe</TableHead>
                        </TableRow>
                    </TableHeader>

                    <!-- body -->
                    <TableBody>
                        <TableRow v-for="certificate in certificates" :key="certificate.id">
                            <TableCell class="font-medium">{{ certificate.name }}</TableCell>
                            <TableCell>{{ certificate.description ?? 'N/A' }}</TableCell>
                            <TableCell>
                                <span :class="{
                                    'text-gray-500': certificate.pivot?.status === 'not evaluated',
                                    'text-green-500': certificate.pivot?.status === 'evaluated',
                                    'text-red-500': certificate.pivot?.status === 'canceled',
                                }">
                                    {{ certificate.pivot?.status || 'N/A' }}
                                </span>
                            </TableCell>
                            <TableCell class="flex justify-center gap-2">
                                <Button size="sm" class="bg-rose-500 text-white hover:bg-rose-700"
                                    @click="unsubscribe(certificate.id)">
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