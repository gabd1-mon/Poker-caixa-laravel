<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    jogador: Object,
});

const form = useForm({
    nome: props.jogador.nome,
    contato: props.jogador.contato,
});

// Garanta que esta função está exatamente assim
const submit = () => {
    form.patch(route('jogadores.update', { jogador: props.jogador.id }));
};
</script>

<template>
    <Head title="Editar Jogador" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Jogador: {{ jogador.nome }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="nome" value="Nome ou Apelido" />
                                <TextInput
                                    id="nome"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.nome"
                                    required
                                    autofocus
                                    autocomplete="off"
                                />
                                <InputError class="mt-2" :message="form.errors.nome" />
                            </div>

                            <div>
                                <InputLabel for="contato" value="Contato (Telefone/ID - Opcional)" />
                                <TextInput
                                    id="contato"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.contato"
                                    autocomplete="off"
                                />
                                <InputError class="mt-2" :message="form.errors.contato" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Salvar Alterações</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Salvo.</p>
                                </Transition>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
