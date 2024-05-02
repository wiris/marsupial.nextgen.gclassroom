<script setup lang="ts">
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
    initiationUrl: string,
    targetLinkUri: string
    ltiLaunchId: string,
    clientId: string
    iss: string,
}>();

const query = new URLSearchParams({
    iss: props.iss,
    login_hint: props.ltiLaunchId,
    target_link_uri: props.targetLinkUri,
    client_id: props.clientId
})

</script>

<template>
    <Head title="Material"></Head>
    <LoggedInLayout>
        <iframe class="size-full h-[1200px]" :src="`${initiationUrl}?${query.toString()}`">
        </iframe>
    </LoggedInLayout>
</template>