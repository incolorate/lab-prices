<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    data: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Hello</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Test</th>
                                <th>Source</th>
                                <th>Price</th>
                                <th>Price updated at</th>
                            </tr>
                        </thead>
                        <tbody v-for="test in data">
                            <tr>
                                <td>{{ test.test_name }}</td>
                                <td>{{ test.source }}</td>
                                <td>{{ test.price }}</td>
                                <td>{{ test.timestamps }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
