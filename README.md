# Poker Caixa - Sistema de Gestão de Caixa

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js)
![Docker](https://img.shields.io/badge/Docker-20.10-2496ED?style=for-the-badge&logo=docker)

Sistema de caixa para casas de poker focado em agilidade e usabilidade para o operador. O sistema controla o fluxo de caixa registrando todas as transações de jogadores (buy-ins e cash-outs) e gera relatórios de fechamento.

## ✨ Funcionalidades

Este sistema foi desenvolvido para ser simples e eficiente, focando nas operações essenciais do dia a dia de uma casa de poker.

* **Gestão de Jogadores (RF01):**
    * Cadastro rápido de novos jogadores (nome e contato opcional).
    * Listagem, edição e exclusão de jogadores cadastrados.

* **Operação de Caixa (RF02):**
    * Tela principal otimizada para registrar **Entradas (Buy-ins)** e **Saídas (Cash-outs)**.
    * Associação de cada transação a um jogador e ao operador do caixa logado.

* **Relatório de Fechamento (RF03):**
    * Geração de um relatório diário com o balanço do caixa.
    * Cálculo automático do total de entradas, total de saídas e o balanço final (lucro/prejuízo).

* **Extrato do Jogador (RF04):**
    * Visualização de um extrato detalhado com todas as transações de um jogador específico para o dia.
    * Cálculo do saldo do jogador para facilitar o pagamento do cash-out.

* **Segurança e Auditoria (RNF02):**
    * Acesso ao sistema protegido por autenticação.
    * Funcionalidade de cancelamento de transações, registrando qual operador realizou a ação, sem apagar o registro permanentemente (Soft Deletes).

## 🚀 Tecnologias Utilizadas

* **Backend:** Laravel 12
* **Frontend:** Vue.js 3 com Inertia.js
* **Banco de Dados:** MySQL 8
* **Ambiente de Desenvolvimento:** Docker com Laravel Sail
* **Estilização:** Tailwind CSS
* **Build Tool:** Vite

## ⚙️ Como Rodar o Projeto (Ambiente de Desenvolvimento)

Este projeto foi configurado para rodar com **Laravel Sail** em um ambiente **WSL2 (Windows Subsystem for Linux)**.

### Pré-requisitos

* Docker Desktop
* WSL2 com uma distribuição Linux (ex: Ubuntu) instalada.
* PHP e Composer instalados localmente (apenas para o passo de clonar dependências iniciais).

### Passos para Instalação

1.  **Clone o repositório para dentro do seu ambiente WSL2:**
    ```bash
    git clone(https://github.com/gabd1-mon/Poker-caixa-laravel)
    cd SEU_REPOSITORIO
    ```

2.  **Instale as dependências do Composer:**
    ```bash
    composer install
    ```

3.  **Copie o arquivo de ambiente:**
    ```bash
    cp .env.example .env
    ```

4.  **Inicie os containers do Docker com o Sail:**
    (Este comando pode demorar alguns minutos na primeira vez)
    ```bash
    ./vendor/bin/sail up -d
    ```

5.  **Gere a chave da aplicação:**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6.  **Execute as migrações do banco de dados:**
    Este comando criará todas as tabelas necessárias.
    ```bash
    ./vendor/bin/sail artisan migrate
    ```

7.  **Instale as dependências do frontend:**
    ```bash
    ./vendor/bin/sail npm install
    ```

8.  **Compile os assets do frontend:**
    Você precisa manter este comando rodando em um terminal separado enquanto desenvolve.
    ```bash
    ./vendor/bin/sail npm run dev
    ```

🎉 **Pronto!** A aplicação estará disponível no seu navegador em **`http://localhost`**.
