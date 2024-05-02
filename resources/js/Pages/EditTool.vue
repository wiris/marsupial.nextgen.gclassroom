<script setup lang="ts">
import { Button } from '@/Components/ui/button';
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
} from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import { Textarea } from '@/Components/ui/textarea';
import { useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';
import { router, Head } from '@inertiajs/vue3';
import { watchEffect } from 'vue';
import { computed } from 'vue';


const props = defineProps<{
    tool?: any,
}>();

const initialValues = computed(() => {
    return {
        ...props.tool,
        redirect_uris: JSON.parse(props.tool?.redirect_uris ?? '[]').join(',')
    }
});

const formSchema = toTypedSchema(z.object({
    title: z.string().min(1).max(50),
    description: z.string().min(1).max(255),
    oidc_initiation_url: z.string().min(1).max(200),
    jwks_url: z.string().min(1).max(200),
    target_link_uri: z.string().min(1).max(200),
    redirect_uris: z.string().min(1).max(200),
    deep_link_url: z.string().min(1).max(200).optional()
}))

const { errors, handleSubmit } = useForm({
    validationSchema: formSchema,
    initialValues: initialValues.value
})

const onSubmit = handleSubmit((values) => {
    if (props.tool) {
        router.patch(route('tools.update', { id: props.tool.id }), values);
    } else {
        router.post(route('tools.store'), values)
    }
})

</script>

<template>

    <Head title="Editar herramienta LTI"></Head>

    <LoggedInLayout>
        <div class="flex flex-col items-center justify-center mx-2">
            <form class="max-w-screen-lg w-full" @submit="onSubmit">
                <div class="justify-start text-2xl my-4">
                    {{ tool ? 'Editar ' : 'Añadir nueva ' }} herramienta LTI
                </div>

                <FormField v-slot="{ componentField }" name="title">
                    <FormItem class="my-2">
                        <FormLabel>Título</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="description">
                    <FormItem class="my-2">
                        <FormLabel>Descripción</FormLabel>
                        <FormControl>
                            <Textarea v-bind="componentField" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="oidc_initiation_url">
                    <FormItem class="my-2">
                        <FormLabel>URL de iniciación de OIDC</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="https://..." v-bind="componentField" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="jwks_url">
                    <FormItem class="my-2">
                        <FormLabel>URL del JWKS</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="https://..." v-bind="componentField" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="target_link_uri">
                    <FormItem class="my-2">
                        <FormLabel>URI objetivo de los links LTI (target link URI)</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="https://..." v-bind="componentField" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="redirect_uris">
                    <FormItem class="my-2">
                        <FormLabel>URIs de las redirecciones</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="https://..." v-bind="componentField" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="deep_link_url">
                    <FormItem class="my-2">
                        <FormLabel>URL de vinculación profunda (deep linking)</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="https://..." v-bind="componentField" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <Button class="mt-2" type="submit">Guardar</Button>
            </form>
        </div>
    </LoggedInLayout>
</template>