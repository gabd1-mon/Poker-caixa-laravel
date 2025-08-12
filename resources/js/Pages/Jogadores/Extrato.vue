<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { computed } from 'vue';

// Recebe os dados do jogador e as suas transações, enviados pelo Controller
const props = defineProps({
    jogador: Object,
    transacoes: Array,
});

// Calcula o saldo final do jogador para o dia
const saldoFinal = computed(() => {
    const totalEntradas = props.transacoes
        .filter(t => t.tipo === 'entrada')
        .reduce((sum, t) => sum + parseFloat(t.valor), 0);

    const totalSaidas = props.transacoes
        .filter(t => t.tipo === 'saida')
        .reduce((sum, t) => sum + parseFloat(t.valor), 0);

    return totalEntradas - totalSaidas;
});

// Define a cor do saldo (verde se positivo, vermelho se negativo)
const saldoColorClass = computed(() => {
    return saldoFinal.value >= 0 ? 'text-green-600' : 'text-red-600';
});

// Função para formatar o valor como moeda brasileira
const formatCurrency = (value) => {
    if (value === null || value === undefined) return 'R$ 0,00';
    return parseFloat(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
};

// Função para formatar a data para mostrar apenas o horário
const formatTime = (dateTime) => {
    if (!dateTime) return '';
    return new Date(dateTime).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
};

// Função para cancelar uma transação
const cancelarTransacao = (transacaoId) => {
    if (confirm('Tem a certeza que deseja cancelar esta transação? Esta ação não pode ser desfeita.')) {
        router.delete(route('transacoes.destroy', { transacao: transacaoId }), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head :title="'Extrato de ' + jogador.nome" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Extrato do Dia: {{ jogador.nome }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Tabela para telas médias e grandes -->
                        <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horário</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="transacao in transacoes" :key="transacao.id">
                                <td class="px-6 py-4 whitespace-nowrap font-medium" :class="transacao.tipo === 'entrada' ? 'text-green-600' : 'text-red-600'">
                                    {{ transacao.tipo.charAt(0).toUpperCase() + transacao.tipo.slice(1) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ formatCurrency(transacao.valor) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ formatTime(transacao.created_at) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button @click="cancelarTransacao(transacao.id)" class="text-red-600 hover:text-red-900 font-semibold">
                                        Cancelar
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Lista de "Cartões" para telas pequenas -->
                        <div class="space-y-4 md:hidden">
                            <div v-for="transacao in transacoes" :key="transacao.id" class="bg-gray-50 p-4 rounded-lg shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="font-bold text-lg" :class="transacao.tipo === 'entrada' ? 'text-green-600' : 'text-red-600'">
                                            {{ transacao.tipo.charAt(0).toUpperCase() + transacao.tipo.slice(1) }}
                                        </div>
                                        <div class="text-xl font-semibold">{{ formatCurrency(transacao.valor) }}</div>
                                    </div>
                                    <div class="text-sm text-gray-500">{{ formatTime(transacao.created_at) }}</div>
                                </div>
                                <div class="mt-4 pt-2 border-t border-gray-200 flex justify-end">
                                    <button @click="cancelarTransacao(transacao.id)" class="text-red-600 hover:text-red-900 text-sm font-semibold">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Mensagem para caso não haja transações -->
                        <div v-if="transacoes.length === 0" class="text-center text-gray-500 py-8">
                            Nenhuma transação registrada para este jogador hoje.
                        </div>

                        <!-- Saldo Final -->
                        <div v-if="transacoes.length > 0" class="mt-6 pt-4 border-t flex justify-end items-center">
                            <span class="text-lg font-bold text-gray-800 mr-4">Saldo do Jogador (Dia):</span>
                            <span class="text-lg font-bold" :class="saldoColorClass">
                                {{ formatCurrency(saldoFinal) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
