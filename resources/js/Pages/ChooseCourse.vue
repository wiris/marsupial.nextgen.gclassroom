<script setup lang="ts">
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

import { Button } from '@/Components/ui/button';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    courses: any[]
}>();

const selectedCourseId = ref();
</script>

<template>

    <Head title="Selección de curso"></Head>

    <LoggedInLayout>
        <div class="flex flex-col items-center justify-center mx-2">
            <div class="max-w-screen-lg w-full">

                <div class="text-xl">
                    Selección de curso
                </div>
                <div class="text-sm">
                    Seleccione el curso de Google Classroom que quiere usar
                </div>
                <Select v-model="selectedCourseId">
                    <SelectTrigger class="w-30 my-3">
                        <SelectValue placeholder="Nombre de la clase" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem v-for="course of courses" :value="course.id">
                                {{ course.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Link v-if="selectedCourseId" :href="route('materials.index', { course: selectedCourseId })">
                <Button>Seleccionar curso</Button>
                </Link>
            </div>
        </div>
    </LoggedInLayout>
</template>