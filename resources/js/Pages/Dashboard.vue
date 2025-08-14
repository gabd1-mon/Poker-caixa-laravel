<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    stats: Object,
    transacoesRecentes: Array,
});

const balancoColorClass = computed(() => {
    const balancoNumerico = parseFloat(props.stats.balanco.replace(/\./g, '').replace(',', '.'));
    return balancoNumerico >= 0 ? 'text-green-600' : 'text-red-600';
});

const formatCurrency = (value) => {
    if (value === null || value === undefined) return 'R$ 0,00';
    return parseFloat(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
};

const formatTime = (dateTime) => {
    if (!dateTime) return '';
    return new Date(dateTime).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Secção de Estatísticas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Card Entradas -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-500 truncate">Total de Entradas (Hoje)</h3>
                        <p class="mt-1 text-3xl font-semibold text-blue-600">R$ {{ stats.entradas }}</p>
                    </div>
                    <!-- Card Saídas -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-500 truncate">Total de Saídas (Hoje)</h3>
                        <p class="mt-1 text-3xl font-semibold text-orange-600">R$ {{ stats.saidas }}</p>
                    </div>
                    <!-- Card Balanço -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-500 truncate">Balanço da Casa (Hoje)</h3>
                        <p class="mt-1 text-3xl font-semibold" :class="balancoColorClass">R$ {{ stats.balanco }}</p>
                    </div>
                </div>

                <!-- Secção de Ações Rápidas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <Link :href="route('caixa.index')" class="group flex flex-col items-center justify-center bg-gradient-to-br from-green-500 to-green-600 text-white font-bold py-6 px-4 rounded-xl text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-lg group-hover:text-green-100 transition-colors">Ir para o Caixa</span>
                        <p class="text-xs font-light group-hover:text-green-200 transition-colors">Registrar Entradas e Saídas</p>
                    </Link>
                    <Link :href="route('jogadores.create')" class="group flex flex-col items-center justify-center bg-gradient-to-br from-indigo-500 to-indigo-600 text-white font-bold py-6 px-4 rounded-xl text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span class="text-lg group-hover:text-indigo-100 transition-colors">Cadastrar Jogador</span>
                        <p class="text-xs font-light group-hover:text-indigo-200 transition-colors">Adicionar novo jogador ao sistema</p>
                    </Link>
                </div>

                <!-- Secção de Atividade Recente -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Atividade Recente</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jogador</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horário</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(transacao, index) in transacoesRecentes" :key="transacao.id" :class="{'bg-gray-50': index % 2 !== 0}">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ transacao.jogador.nome }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium" :class="transacao.tipo === 'entrada' ? 'text-green-600' : 'text-red-600'">
                                        {{ transacao.tipo.charAt(0).toUpperCase() + transacao.tipo.slice(1) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ formatCurrency(transacao.valor) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatTime(transacao.created_at) }}</td>
                                </tr>
                                <tr v-if="transacoesRecentes.length === 0">
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nenhuma transação registrada hoje.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
