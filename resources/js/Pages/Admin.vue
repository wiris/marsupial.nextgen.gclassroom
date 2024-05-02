<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import { Card, CardHeader, CardTitle, CardDescription, CardFooter, CardContent } from '@/Components/ui/card'
import { Input } from '@/Components/ui/input';
import { Head, Link } from '@inertiajs/vue3';
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref } from 'vue';

defineProps<{
}>();

const email = ref('');
</script>

<template>
    <Head title="Administración de herramientas LTI"></Head>

    <LoggedInLayout>
        <div class="flex flex-col items-center justify-center mx-2">
            <div class="max-w-screen-lg w-full">
                <div class="justify-start text-2xl my-4">
                    Panel de administrador
                </div>

                <div class="justify-start text-xl">
                    Administración de usuarios
                </div>

                <div class="my-2">
                    Correo electrónico:
                    <div class="flex">
                        <Input type="text" class="w-[300px] mr-3" v-model="email"></Input>
                        <Link :href="route('users.edit.byemail', {email: email})"><Button>Ver usuario</Button></Link>
                    </div>
                </div>

                <div class="justify-start text-xl my-4">
                    Administración de herramientas LTI
                </div>

                <Link :href="route('tools.index')"><Button>Ver herramientas LTI</Button></Link>
            </div>
        </div>
    </LoggedInLayout>
</template>

<style></style>
