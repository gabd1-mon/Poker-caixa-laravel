<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {router} from "@inertiajs/vue3";

// defineProps é como o componente declara os "pacotes" de dados que ele espera receber do controller.
// Aqui, estamos dizendo que esperamos receber um pacote chamado 'jogadores'.
defineProps({
    jogadores: Object,
});

const deleteJogador = (jogadorId) => {
    if (confirm('Tem certeza que deseja deletar este jogador? Todas as suas transações também serão perdidas permanentemente.')) {
        router.delete(route('jogadores.destroy', jogadorId));
    }
};


</script>

<template>
    <Head title="Jogadores" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lista de Jogadores</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="flex justify-end mb-4">
                            <Link :href="route('jogadores.create')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cadastrar Novo Jogador
                            </Link>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contato</th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contato
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>

                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="jogador in jogadores" :key="jogador.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ jogador.id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ jogador.nome }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ jogador.contato }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-4">
                                    <Link :href="route('jogadores.extrato', jogador.id)" class="text-indigo-600 hover:text-indigo-900">
                                        Extrato
                                    </Link>
                                    <Link :href="route('jogadores.edit', jogador.id)" class="text-blue-600 hover:text-blue-900">
                                        Editar
                                    </Link>
                                    <button @click="deleteJogador(jogador.id)" class="text-red-600 hover:text-red-900 font-semibold">
                                        Deletar
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </AuthenticatedLayout>
</template>
