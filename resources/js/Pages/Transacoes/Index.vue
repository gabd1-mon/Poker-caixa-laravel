<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

// Recebemos a lista de jogadores que o Controller nos enviou
const props = defineProps({
    jogadores: Array,
});

// Usaremos um único formulário para ambas as operações
const form = useForm({
    jogador_id: null,
    valor: '',
    tipo: '', // Será 'entrada' ou 'saida'
});

// Função para submeter a transação
const submitTransacao = (tipoTransacao) => {
    form.tipo = tipoTransacao; // Define o tipo baseado no botão clicado

    // O formulário será enviado para a rota 'transacoes.store' que ainda vamos criar
    form.post(route('transacoes.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset('valor'), // Limpa apenas o campo de valor após o sucesso
    });
};
</script>

<template>
    <Head title="Operação de Caixa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Caixa da Casa</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Registrar Nova Transação</h3>

                        <form @submit.prevent class="space-y-6">
                            <div>
                                <InputLabel for="jogador" value="Selecione o Jogador" />
                                <select
                                    id="jogador"
                                    v-model="form.jogador_id"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required
                                >
                                    <option :value="null" disabled>-- Escolha um jogador --</option>
                                    <option v-for="jogador in jogadores" :key="jogador.id" :value="jogador.id">
                                        {{ jogador.nome }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.jogador_id" />
                            </div>

                            <div>
                                <InputLabel for="valor" value="Valor da Transação (R$)" />
                                <TextInput
                                    id="valor"
                                    type="number"
                                    step="0.01"
                                    class="mt-1 block w-full"
                                    v-model="form.valor"
                                    required
                                    placeholder="Ex: 150.50"
                                />
                                <InputError class="mt-2" :message="form.errors.valor" />
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <PrimaryButton
                                    @click="submitTransacao('saida')"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing || !form.jogador_id || !form.valor"
                                    class="bg-red-600 hover:bg-red-500 focus:bg-red-700 active:bg-red-700"
                                >
                                    Registrar Saída (Cash-out)
                                </PrimaryButton>

                                <PrimaryButton
                                    @click="submitTransacao('entrada')"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing || !form.jogador_id || !form.valor"
                                >
                                    Registrar Entrada (Buy-in)
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
