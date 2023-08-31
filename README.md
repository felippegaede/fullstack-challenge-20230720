# fullstack-challenge-20230720

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