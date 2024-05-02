<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import { Card, CardHeader, CardTitle, CardDescription, CardFooter, CardContent } from '@/Components/ui/card'
import { Head, Link } from '@inertiajs/vue3';
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';

defineProps<{
    tools: any[],

}>();
</script>

<template>

    <Head title="Administración de herramientas LTI"></Head>

    <LoggedInLayout>

        <div class="flex flex-col items-center justify-center mx-2">
            <div class="max-w-screen-lg w-full">
                <div class="justify-start text-2xl my-4">
                    Administración de herramientas LTI
                </div>

                <div class="justify-start text-lg">
                    URLs de la plataforma
                </div>

                <div class="justify-start my-2 text-sm">
                    URL de autenticación OIDC: {{ route('oidc.auth') }} <br>
                    URL del JWKS: {{ route('oidc.jwks') }} <br>
                    URL para la obtención de tokens: {{ route('token') }}
                </div>

                <div class="justify-start text-xl my-4">
                    Herramientas conectadas
                </div>

                <Card v-for="tool of tools" class="my-2">
                    <CardHeader>
                        <CardTitle>
                            {{ tool.title }}
                        </CardTitle>
                        <CardDescription>
                            {{ tool.description }}
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="text-xs text-neutral-400">
                        <div> Client ID: {{ tool.id }} </div>
                        <div> Deployment ID: {{ tool.deployments[0].id }} </div>
                    </CardContent>
                    <CardFooter class="justify-end">
                        <Link :href="route('tools.edit', { tool: tool.id })">
                        <Button class="mx-1 ">Editar herramienta</Button>
                        </Link>
                    </CardFooter>
                </Card>

                <Link :href="route('tools.create')"><Button>Importar un nueva
                    herramienta</Button></Link>
            </div>
        </div>
    </LoggedInLayout>
</template>

<style></style>
