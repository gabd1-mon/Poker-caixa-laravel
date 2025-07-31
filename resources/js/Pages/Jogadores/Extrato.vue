<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import {router} from "@inertiajs/vue3";

// Recebe os dados do jogador e suas transações, enviados pelo Controller
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
    return parseFloat(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
};

// Função para formatar a data para mostrar apenas o horário
const formatTime = (dateTime) => {
    return new Date(dateTime).toLocaleTimeString('pt-BR');
};
//Função para cancelar transações
const cancelarTransacao = (transacaoId) => {
    // Adiciona um pop-up de confirmação para segurança
    if (confirm('Tem a certeza que deseja cancelar esta transação? Esta ação não pode ser desfeita.')) {
        // Envia uma requisição DELETE para a rota que vamos criar
        router.delete(route('transacoes.destroy', transacaoId), {
            preserveScroll: true, // Mantém a posição da página após a ação
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
                        <table class="min-w-full divide-y divide-gray-200">
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
                                    <button
                                        @click="cancelarTransacao(transacao.id)"
                                        class="text-red-600 hover:text-red-900 font-semibold"
                                    >
                                        Cancelar
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="transacoes.length === 0">
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Nenhuma transação registrada para este jogador hoje.</td>
                            </tr>
                            </tbody>
                        </table>

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
