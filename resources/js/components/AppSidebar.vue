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
import { BookText, LibraryBig } from 'lucide-vue-next';

const { props } = usePage();
const userRole = props.userRole;

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
        href: '',
        icon: BookText,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <!-- <NavMain :items="mainNavItems" /> -->
            <NavMain :items="userRole === 'administrador' ? mainAdminNavItems : mainUserNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
