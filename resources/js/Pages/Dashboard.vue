<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    count: Number,
    availableIn: String,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>
                            <b> You're logged in! </b>You can only access this
                            page 20 times per hour.
                        </p>

                        <p>
                            <i
                                >After <b v-if="count < 0">last attempts</b>
                                <b v-else>{{ count }} attempts</b>, you can only
                                retry after
                                {{ availableIn }}
                            </i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
