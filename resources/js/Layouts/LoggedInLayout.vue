<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const role = computed(() => page.props.auth.user.role);

</script>

<template>
    <head class="w-full h-15 flex justify-between p-2 bg-primary">
        <div class="text-2xl text-secondary ml-4">
            <Link :href="route('materials.index')">Marsupial Next Gen</Link>
        </div>
        <div>
            <Link v-if="role == 'admin'" :href="route('admin')"><Button class="mx-1"
                variant="secondary">Admin</Button></Link>
            <Link :href="route('logout')">
            <Button class="mx-1" variant="secondary">Salir</Button>
            </Link>
        </div>
    </head>
    <main class="p-2 ml-4 m-2">
        <slot></slot>
    </main>
</template>

