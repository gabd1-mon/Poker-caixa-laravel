
<template>


    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cadastrar Novo Jogador</h2>
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
                                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>

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







<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

// O helper 'useForm' do Inertia cria um objeto reativo
// que contém os dados do formulário, validação de erros, etc.
const form = useForm({
    nome: '',
    contato: '',
});

// Esta função será chamada quando o formulário for enviado.
const submit = () => {
    // O 'form.post' envia os dados do formulário para a rota nomeada 'jogadores.store'
    // que criamos com o Route::resource.
    form.post(route('jogadores.store'), {
        // Opcional: você pode adicionar um callback para quando a requisição terminar com sucesso.
        // onFinish: () => form.reset('nome', 'contato'),
    });
};
</script>
