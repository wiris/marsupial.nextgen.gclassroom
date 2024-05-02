<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    redirect?: string
}>();

</script>

<template>
    <Head title="Registro" />

    <div class="h-screen flex flex-col items-center justify-center">
        Bienvenido al conector de Marsupial NextGen para Google Clasroom. Por favor, identifícate.
        <div class="flex my-3">
            <Link :href="route('login.google')">
            <Button>Entrar con Google</Button>
            </Link>
        </div>
    </div>
</template>


<style></style>
