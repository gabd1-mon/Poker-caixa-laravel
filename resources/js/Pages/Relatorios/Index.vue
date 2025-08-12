<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

// Recebe os totais e a data que o Controller nos enviou
const props = defineProps({
    totalEntradas: String,
    totalSaidas: String,
    balancoFinal: String,
    dataConsulta: String, // Prop para receber a data consultada
});

// Estado reativo para o campo de data, inicializado com a data que veio do backend
const dataSelecionada = ref(props.dataConsulta);

// Lógica para definir a cor do balanço (verde se positivo, vermelho se negativo)
const balancoColorClass = computed(() => {
    // Removemos a formatação para verificar se o número é negativo
    const balancoNumerico = parseFloat(props.balancoFinal.replace(/\./g, '').replace(',', '.'));
    return balancoNumerico >= 0 ? 'text-green-600' : 'text-red-600';
});

// Função para buscar o relatório da nova data selecionada
const buscarRelatorio = () => {
    router.get(route('relatorio.index'), {
        data: dataSelecionada.value
    }, {
        preserveState: true, // Mantém o estado do componente (útil para filtros)
        preserveScroll: true, // Mantém a posição da página
    });
};
</script>

<template>
    <Head title="Relatório de Caixa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Relatório de Fechamento de Caixa</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <!-- Formulário de Filtro de Data -->
                        <div class="mb-6">
                            <label for="data" class="block text-sm font-medium text-gray-700">Consultar data:</label>
                            <input
                                type="date"
                                id="data"
                                v-model="dataSelecionada"
                                @change="buscarRelatorio"
                                class="mt-1 block w-full md:w-1/2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>

                        <!-- Resumo Financeiro -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b pb-2">
                                <span class="text-lg font-medium text-gray-600">Total de Entradas (Buy-ins):</span>
                                <span class="text-lg font-bold text-blue-600">R$ {{ totalEntradas }}</span>
                            </div>

                            <div class="flex justify-between items-center border-b pb-2">
                                <span class="text-lg font-medium text-gray-600">Total de Saídas (Cash-outs):</span>
                                <span class="text-lg font-bold text-orange-600">R$ {{ totalSaidas }}</span>
                            </div>

                            <div class="flex justify-between items-center pt-4">
                                <span class="text-xl font-bold text-gray-800">Balanço Final (Casa):</span>
                                <span class="text-xl font-bold" :class="balancoColorClass">R$ {{ balancoFinal }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
