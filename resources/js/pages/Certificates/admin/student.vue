<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Certificate, type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import { computed } from 'vue';
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

import { defineProps } from 'vue';

// Recibir las props que contienen los datos de certificados
const props = defineProps({
    certificates: Array as () => Array<Certificate>
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Students',
        href: '/students',
    },
];

</script>

<template>
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">

                <Table>
                    <TableCaption>Certificates List.</TableCaption>
                    <TableHeader>
                        <!-- Header -->
                        <TableRow>
                            <TableHead>Student</TableHead>
                        </TableRow>
                    </TableHeader>

                    <!-- Body -->
                    <TableBody>
                        <!-- Recorrer los estudiantes de cada certificado -->
                        <TableRow v-for="certificate in certificates" :key="certificate.id">

                            <TableRow v-for="user in certificate.users" :key="user.id">
                                <!-- Mostrar datos del estudiante -->
                                <TableCell>{{ user.name }}</TableCell>
                                <TableCell>{{ user.email }}</TableCell>
                                <TableCell>{{ certificate.name }}</TableCell>
                                <TableCell>{{ user.pivot.status }}</TableCell>
                                <Button as-child size="sm" class="bg-blue-500 text-white hover:bg-blue-700">
                                    <Link :href="`/student/${certificate.id}/edit`">
                                    <FilePenLine />
                                    </Link>
                                </Button>
                            </TableRow>


                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
