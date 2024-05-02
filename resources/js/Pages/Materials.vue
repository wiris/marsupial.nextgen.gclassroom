<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import { Card, CardHeader, CardTitle, CardDescription, CardFooter, CardContent } from '@/Components/ui/card'
import { Head, Link } from '@inertiajs/vue3';
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';

defineProps<{
    materials: any[],
    course: any,

}>();
</script>

<template>
    <Head title="Lista de materiales"></Head>

    <LoggedInLayout>
        <div class="flex flex-col items-center justify-center mx-2">
            <div class="max-w-screen-lg w-full">
                <div class="justify-start text-2xl my-4">
                    Materiales del curso {{ course.name }}
                </div>

                <div class="flex justify-end">
                    <Link :href="route('materials.create', { course: course.id })"><Button>Importar un nuevo
                        material</Button></Link>
                </div>

                <Card v-for="material of materials" class="my-2">
                    <CardHeader>
                        <CardTitle>
                            {{ material.title }}
                        </CardTitle>
                        <CardDescription>
                            {{ material.description }}
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="text-xs text-neutral-400">
                        Herramienta: {{ material.tool_deployment.tool.title }}
                    </CardContent>
                    <CardFooter class="justify-end">
                        <Link :href="route('materials.show', { material: material.id })">
                        <Button class=" mx-1">Ver material</Button>
                        </Link>
                        <Button class="mx-1" variant="secondary">Borrar material</Button>
                    </CardFooter>
                </Card>

            </div>
        </div>
    </LoggedInLayout>
</template>

<style></style>
