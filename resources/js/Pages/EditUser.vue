<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import { Head, Link, router } from '@inertiajs/vue3';
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select';
import { ref } from 'vue';

const props = defineProps<{
    id: string,
    email: string,
    name: string,
    role: string
}>();

const roles = 
[{
    id: 'admin',
    title: 'Administrador'
},
{
    id: 'teacher',
    title: 'Profesor'
},
{
    id: 'student',
    title: 'Estudiante'
}];

const selectedRole = ref(props.role);

const submit = () => {
    router.patch(route('users.update', { id: props.id }), {role: selectedRole.value});
}

</script>

<template>
    <Head title="Administración de herramientas LTI"></Head>

    <LoggedInLayout>
        <div class="flex flex-col items-center justify-center mx-2">
            <div class="max-w-screen-lg w-full">
                <div class="justify-start text-2xl my-4">
                    Usuario {{ name }}
                </div>
                
                Identificador: {{ id }} <br>
                Correo electrónico: {{ email }} <br><br>
                Rol
                <Select v-model="selectedRole">
                    <SelectTrigger class="w-30 my-3">
                        <SelectValue placeholder="Herramienta LTI" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem v-for="option of roles" :value="option.id">
                                {{ option.title }}
                            </SelectItem>
                        </SelectGroup>
                </SelectContent>
            </Select>
                <Button @click="submit">Confirmar</Button>
            </div>
        </div>
    </LoggedInLayout>
</template>

<style></style>
