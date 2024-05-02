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
    tools: any[],
    courseId: string
}>();

const selectedToolId = ref();
</script>

<template>

    <Head title="Compartir material"></Head>
    <LoggedInLayout>

        <div class="flex flex-col items-center justify-center mx-2">
            <div class="max-w-screen-lg w-full">

                <div class="text-xl">
                    Selección de herramienta LTI
                </div>
                <div class="text-sm">
                    Selecciona la herramienta LTI:
                </div>
                <Select v-model="selectedToolId">
                    <SelectTrigger class="w-30 my-3">
                        <SelectValue placeholder="Herramienta LTI" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem v-for="tool of tools" :value="tool.id">
                                {{ tool.title }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Link v-if="selectedToolId" :href="route('lti.dl.link', { tool: selectedToolId, course: courseId })">
                <Button>Seleccionar herramienta</Button>
                </Link>
            </div>
        </div>
    </LoggedInLayout>
</template>