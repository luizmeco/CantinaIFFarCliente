# 🛒 Cantina IFFar - Cliente (Totem de Autoatendimento)

Este é o repositório do cliente (totem de autoatendimento) do sistema **Cantina IFFar**, desenvolvido utilizando o framework **CodeIgniter 4**. Através desta interface, os alunos e servidores realizam os seus pedidos.

---

## 🚀 Como Executar o Projeto

Siga as instruções abaixo para configurar e rodar o projeto do Cliente localmente em sua máquina.

### 📋 Pré-requisitos
Antes de começar, certifique-se de possuir instalado em seu ambiente:
* **PHP** (versão 8.1 ou superior recomendada)
* **Composer**
* A [API da Cantina IFFar](file:///c:/xampp/htdocs/CantinaIFFarAPI/README.md) configurada e em execução.

---

## 🛠️ Passo a Passo para Configuração

> [!NOTE]
> Todos os comandos abaixo devem ser executados no **Prompt de Comando (cmd)** ou terminal de sua preferência, dentro da pasta raiz deste projeto (`CantinaIFFarCliente`).

### 1. Clonar e Acessar o Diretório
Se você ainda não estiver na pasta do projeto:
```cmd
cd CantinaIFFarCliente
```

### 2. Configurar o Arquivo de Ambiente (.env)
Copie o arquivo de exemplo `.env.example` criando o seu arquivo `.env` definitivo:
```cmd
copy .env.example .env
```

> [!IMPORTANT]
> Abra o arquivo `.env` recém-criado e verifique se a URL base da API e o ID do Totem estão configurados corretamente de acordo com as necessidades do seu ambiente local.

### 3. Instalar as Dependências do Composer
Baixe todas as dependências e bibliotecas necessárias para o projeto rodar:
```cmd
composer install
```

### 4. Iniciar o Servidor de Desenvolvimento
Como a API por padrão utiliza a porta `8080`, rode o cliente em uma porta alternativa (como a `8081`):
```cmd
php spark serve --port 8081
```

O painel de autoatendimento do cliente estará acessível em: `http://localhost:8081`
