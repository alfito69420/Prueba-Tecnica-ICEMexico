<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { BookText, LibraryBig, User } from 'lucide-vue-next';

const { props } = usePage();
const userRole = props.userRole;
const { url } = usePage();  // Acceder a la URL actual

console.log('User Role:', userRole);
console.log('Current URL:', url);

const mainUserNavItems: NavItem[] = [
    {
        title: 'Certificates',
        href: '/certificates',
        icon: LibraryBig,
    },
    {
        title: 'My Certificates',
        href: '/my-certificates',
        icon: BookText,
    },
];

const mainAdminNavItems: NavItem[] = [
    {
        title: 'Certificates',
        href: '/certificates',
        icon: LibraryBig,
    },
    {
        title: 'Students',
        href: '/students',
        icon: User,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <AppLogo />
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <!-- <NavMain :items="mainNavItems" /> -->
            <NavMain :items="userRole === 'administrador' ? mainAdminNavItems : mainUserNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
