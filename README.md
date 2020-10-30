# 🏡 Propriedades e Contratos 📑 

### Instalação
```
git clone https://github.com/nicolastanski/laravel-test-backend.git
cd laravel-test-backend
docker-composer up
```

--------

### Sobre a Accordous
##### Não perca mais tempo com seus contratos.
Somos uma empresa de tecnologia voltada a simplificação de processos burocráticos! Desde a concepção até a cobrança de contratos, seja ele de imóveis, acordo, prestação de serviços, entre outros.


##### Teste Full Stack Laravel
O objetivo deste teste é entendermos um pouco mais sobre seus conhecimentos de Frontend e Backend no Laravel.

##### Requisitos
- PHP 7.1+
- Laravel (Preferência 5.8+)
- Vue.JS
- Docker Engine

##### Orientações
Faça um fork deste projeto.

Para facilitar o seu desenvolvimento, nós disponibilizamos um ``docker-compose.yml`` com o serviços que utilizamos habitualmente no nosso dia a dia.

#### O Desafio
Simular o cadastro de uma propriedade e criar um contrato para o mesmo.

##### Funcionalidade 1:
  - Permitir o cadastro de um imóvel com algumas características. 
  - o cadastro de um imóvel deve possuir:
  - e-mail do proprietário, rua, número, complemento, bairro, cidade, estado;

Para que o cadastro ocorra deverá haver validações em dois níveis. Frontend e backend:
- 1 - e-mail, rua, bairro, cidade e estado são campos obrigatórios;
- 2 - e-mail deverá ser validado;

##### Funcionalidade 2:
  - Contexto: Permitir visualização dos imóveis cadastrados.
    Os dados de imóveis deverão ser carregados via request assíncrona. Esses dados deverão ser exibidos numa tabela e ao menos uma das colunas serem ordenáveis.
    Dados que deverão ser exibidos na tabela:
  - E-mail do proprietário;
  - Rua, número, cidade, estado (separados por vírgula);
  - Status (Contratado / Não contratado)
  - Coluna para ações (remover).

##### Funcionalidade 3:
  - Contexto: permitir a remoção de uma propriedade via chamada assíncrona com atualização posterior da lista de propriedades.
  - Observação: a remoção de uma propriedade deverá ser virtual.

##### Funcionalidade 4:
  - Contexto: Criação de um contrato que permita associação com uma propriedade. Um contrato possui os seguintes campos:
  - Propriedade (deverá ser selecionável a propriedade. Sendo usado como informação da propriedade a rua, número, complemento, bairro);
  - Tipo de pessoa (Pessoa física ou Pessoa Jurídica);
  - Documento (A máscara do campo de documento deverá alterar de acordo com o tipo de pessoa. Pessoa física deverá ser máscara de CPF e pessoa jurídica deverá ser máscara de CNPJ)
  - E-mail do contratante;
  - Nome completo do contratante;

##### Regras específicas sobre a criação de contrato:
- Uma propriedade não pode estar associada a dois contratos;
- Todos os campos do contrato são obrigatórios;
- Deverá ocorrer validação do documento;
- Deverá ocorrer validação do e-mail;


### Extras
- Job: deve-se utilizar alguma forma de job;
- Teste unitário de backend;
- Teste de integração backend;
- SPA.
- Usabilidade (A usabilidade das funcionalidades fica a cargo do desenvolvedor) :D


### Entrega
Deixar um repositório público e nos enviar por e-mail - o mesmo e-mail que foi enviado o teste.
