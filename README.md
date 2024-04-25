<p align="center">
  <a href="https://www.php.net/" target="_blank"><img src="https://www.php.net/images/logos/new-php-logo.svg" width="300" alt="Php Logo"></a>
</p>

# Teste Backend - ACSoftware

Desenvolvimento de uma API RESTful para Gerenciamento de Lista de Tarefas (Todo List)

![Badge em Desenvolvimento](http://img.shields.io/static/v1?label=STATUS&message=EM%20DESENVOLVIMENTO&color=GREEN&style=for-the-badge)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

## 🚀 Iniciando

Estas instruções permitirão que você obtenha uma cópia do projeto em execução em sua máquina local para fins de desenvolvimento e teste.

### 📋 Pré-requisitos

O que você precisa para instalar o software e como instalá-lo?

|Technologies    |PHP                            |Composer                     |
|----------------|-------------------------------|-----------------------------|
|Version         |`8.2.18`                        |`2.7.4`                      |

## 🔧 Instalação

1. Clone o repositório:
```
git clone https://github.com/JosePedro-22/Teste-apiTodoList.git
```
2. Navegue até o diretório do projeto:
```
cd Teste-apiTodoList
```
3. Instale dependências:
```
composer install
```
4. rode o projeto:
```
php -S localhost:8000 -t public
```

## 🎲 As principais decisões técnicas que tomei:

* Linguagem: PHP é amplamente utilizado e possui uma grande comunidade de desenvolvedores e recursos disponíveis.
* Arquitetura: optei por aplicá-la de forma simples e organizar o código em diferentes camadas. Isso ajuda a manter uma separação clara de responsabilidades e facilita a manutenção e a escalabilidade dos aplicativos.
* Validação de dados: A validação de dados foi implementada para garantir que os dados recebidos pela API estejam corretos e completos. Isso ajuda a evitar erros e problemas de segurança.
* Saída da API: formato JSON.

## 🎲 Sobre

|Name Branch     |Description                                                  |
|----------------|-------------------------------------------------------------|
|master          |projeto base, implementação do algoritmo para criação de Tarefa|

## 🛠️ Feito com

* [Php](https://www.php.net/) - A linguagem usada
* [Composer](https://getcomposer.org/) - Gerenciador de Dependências

## ✒️ Autor

* **José Pedro** - *Development / Documentation* - [Developer](https://www.linkedin.com/in/josepedro-sm/)
