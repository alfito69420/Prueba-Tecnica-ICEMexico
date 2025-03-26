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

interface CertificatesPageProps extends SharedData {
    certificates: Certificate[];
}

const { props } = usePage<CertificatesPageProps>();
const certificates = computed(() => props.certificates);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Students',
        href: '/students',
    },
];

</script>

<template>

    <head title="Certificates" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">

                <Table>
                    <TableCaption>Students Enrolled in Certificates.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Student</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Certificate</TableHead>
                            <TableHead>Status</TableHead>
                        </TableRow>
                    </TableHeader>

                    <!-- body -->
                    <TableBody>
                        <!-- <TableRow v-for="certificate in certificates" :key="certificate.id">
                            <TableCell colspan="4" class="font-medium">
                                {{ certificate.name }}
                            </TableCell>
                        </TableRow> -->

                        <!-- Recorrer los estudiantes de cada certificado -->
                        <!-- <TableRow v-for="user in certificate.users" :key="user.id">
                            <TableCell>{{ user.name }}</TableCell>
                            <TableCell>{{ user.email }}</TableCell> 
                            <TableCell>{{ certificate.name }}</TableCell> 
                            <TableCell>{{ user.$pivot.status }}</TableCell>
                        </TableRow> -->
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
