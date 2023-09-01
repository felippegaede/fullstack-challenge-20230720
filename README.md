# Fullstack Challenge 20230720

## Descrição
Este projeto é parte do Fullstack Challenge 20230720 e se trata de um sistema que filtra, ordena e apresenta uma listagem de planos com base em critérios específicos.

## Linguagens, frameworks e tecnologias usadas
* Docker
* PHP 8.2
* Composer

## Como instalar e usar o projeto
Siga estas instruções para clonar, configurar e executar o projeto em sua máquina.

### Pré-requisitos
* Git (para clonar o repositório)
* Docker (opcional, mas recomendado)
* PHP e Composer (caso não esteja usando o Docker)

### Passos

1. #### Clonar o Repositório
Abra o terminal e execute o seguinte comando para clonar este repositório:

```git clone https://github.com/felippegaede/fullstack-challenge-20230720.git```

2. #### Navegar até a Raiz do Projeto

Navegue para a pasta raiz do projeto usando o comando cd:

```cd fullstack-challenge-20230720```
 
3. #### Iniciar o Projeto com Docker (Recomendado)
Se você tiver o Docker instalado, execute o seguinte comando para iniciar o projeto:

``` make start-docker```  

Isso iniciará o projeto em um contêiner Docker isolado.

Nota: Se você optar por não usar o Docker, siga o próximo passo.

4. #### Iniciar o Projeto sem Docker
Se o Docker não estiver instalado, você pode iniciar o projeto com as seguintes etapas:
* Certifique-se de ter o PHP e o Composer instalados em sua máquina.
* Execute os seguintes comandos para instalar as dependências e iniciar o servidor:

```make start```

5. #### Acessar a Aplicação
Abra um navegador e acesse o seguinte endereço para ver a lista de planos filtrada e ordenada:

```http://localhost:8080/api/plans ``` 

## Projeto referência
Este projeto é baseado no desafio proposto pela [4yousee](https://bitbucket.org/4yousee/avaliacao-desenvolvedor/src/master/
).

## Algoritmo
O processo de filtragem e ordenação dos planos é realizado em etapas, conforme descrito abaixo:

#### Passo 1: Filtragem de Planos Inválidos

* Remove da listagem de planos todos os planos com startDate posterior à data atual.
#### Passo 2: Ordenação dos Planos

* Ordena a listagem de planos válidos em ordem decrescente de startDate e prioridade de localidade.
#### Passo 3: Criação do Array de Resposta

* Inicializa um array vazio que conterá o resultado final.
#### Passo 4: Remoção de Duplicatas por Nome

* Percorre a lista de planos ordenada e insere no array final somente a primeira ocorrência de cada nome de plano.

Este processo garante que não haverá dois ou mais planos com mesmo nome na resposta final, e como a listagem estará ordenada, a primeira ocorrência de cada plano, com mesmo nome, será sempre a que possuir o startDate mais recente. Caso ocorra de ter dois ou mais planos com mesmo nome e mesma data de início, o plano que possuir a maior prioridade de localidade também sempre aparecerá primeiro, assim possibilitando, pegar também o de primeira ocorrência. 

Para a ordenação da listagem principal, foi utilizada a função "usort" do PHP e o operador spaceship (<=>). Em que primeiro é feito uma verificação na data de início. Caso as duas datas comparadas sejam iguais, o resultado da comparação, feita com spaceship, retornará 0 e então é feito uma nova comparação, utilizando o mesmo operador, porém, desta vez no campo prioridade. 

>  This is a challenge by [Coodesh](https://coodesh.com/)