<script setup lang="ts">
import { Separator } from '@/Components/ui/separator';
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';

defineProps<{
    material: any,

}>();
</script>


<template>
    <LoggedInLayout>
        <div class="size-full h-[92vh]">
            <div>
                <div class="text-2xl m-2">
                    {{ material.title }}
                </div>
                <div class="text-sm text-slate-500 m-2">
                    {{ material.description }}
                </div>
                <Separator class="mx-2 bg-neutral-300"></Separator>
            </div>
            <div class="m-2 h-full">
                <slot></slot>
            </div>
        </div>
    </LoggedInLayout>
</template>

