# Api Registro Epidemiológico de Doenças Raras
É uma aplicação RESTful que consiste em um registro epidemiológico para pacientes com doenças raras a servir aplicações que podem ser outros sistemas ou uma interface de usuário.

## Diagrama de Entidade Relacionamento
<img src="https://github.com/Aleika/registro-epidemiologico/blob/main/database/registro_epidemiologico_diagrama.svg">

## Instruções de instalação

## Instalação do PHP 8.0.2

Para a instalação do PHP, vamos utilizar o pacote XAMPP
- [Fazer download do XAMPP](https://www.apachefriends.org/download.html).
Escolha a opção de download para a versão PHP 8.0.2 e para seu SO.

## Instalação do Composer
Para instalar o Composer, acesse o link abaixo e realize a instalação de acordo com sua preferência e SO.
- [Fazer download do Composer](https://getcomposer.org/download/).

Observações: 
- No processo de instalação do Composer, caso necessário, selecione o XAMPP.
- Caso seu SO seja Windows: para ativar o Composer é necessário executar o Prompt de Comando como administrado e rodar o comando `php composer.phar`.

## Instalação do banco de dados (postgres)
O projeto foi desenvolvido utilizando o postgres, então para que o projeto funcione é necessário fazer a instalação do postgres. Para isso, faça o download pelo [link](https://www.postgresql.org/download/). Escolha seu SO e prossiga com a instalação. 

Observação: A versão do PostgreSQL instalada para o projeto foi a 13.2. Caso prefira, também realize a instalação do pgAdmin durante o processo de instalação do postgres.

## Clonando repositório do Git
Para que seja possível fazer o clone do projeto é necessário que você tenha o Git configurado no seu computador. Como sugestão para instalação do Git, seguir dados passados no [link](https://www.atlassian.com/br/git/tutorials/install-git).

Para clonar o projeto é possível utilizar dois métodos:
- HTTPS: `https://github.com/Aleika/registro-epidemiologico.git`
- SSH: `git@github.com:Aleika/registro-epidemiologico.git` (para usar esse método é necessário configurar as chaves SSH no git.)

## Configurando dependências do projeto
Após realizar o clone, entre na pasta doprojeto e execute o comando para que as dependências sejam instaladas:

```composer install```

## Configurando variáveis de ambiente
Copiar o arquivo `.env.example` para o arquivo `.env`. Após isso, gerar a chave de aplicação com o comando `php artisan key:generate`.

## Configurando os dados para acesso ao banco de dados
No arquivo `.env`, substitua o seguinte trecho:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=registro_epidemiologico
DB_USERNAME= NOME_USUARIO
DB_PASSWORD= SENHA
```
Veja que para que funcione, é necessário que seja criado um banco com o nome 'registro_epidemiologico' e é necessário informar o nome do usuário e senha que foram criados por você durante a instalação do postgres. Caso tenha alguma dessas informações configurada de forma diferente, basta substituir. O importante é que as informações correspondam ao servidor de banco de dados que você configurou anteriormente.

Observação: Abra o arquivo xampp/php/php.init e descomente as linhas:

```extension=pdo_pgsql```

```extension=pgsql```

## Realizar a migração dos dados
Para a criação das tabelas e inserção de dados via migration, execute o comando:

```php artisan migrate```

## Executar seeders
Os seeders contém dados para serem inseridos no banco no momento em que são chamados. Execute os seguintes seeders na ordem exibida:

```php artisan db:seed --class=FaixaEtariaSeeder```

```php artisan db:seed --class=UserSeeder```

Caso deseje inserir dados referentes à município, paciente, pesquisador e registro de doenças do paciente - montando alguns cenários iniciais - execute o seeder:

```php artisan db:seed --class=PopulandoTabelasSeeder```

## Executar servidor localmente
Por fim, para executar o servidor localmente é necessário apenas executar o comando:

```php artisan serve```

## Acessando a documentação da API
Para visualizar a documentação da API, basta acessar o caminho pelo brownser (após subir o servidor local): 

```http://localhost:8000/api/documentation```

Observação: Para conseguir utilizar as funcionalidades do módulo de gestão, que necessitam que o usuário esteja autenticado, acesse primeiramente `http://127.0.0.1:8000/api/auth/login` passando no corpo da resquet o email 'admin@email.com' e a senha '123456' (qualquer dúvida consulte a documentação da api). Essas informações foram inseridas via seeder do usuário. Apenas após fazer login no sistema, o usuário terá o token que liberará o acesso às funcionalidades que necessitam de permissão. É importante destacar que, de acordo com o que foi implemetado, apenas esse usuário 'administrador' poderá fazer o registro de outros novos usuários. Isso impede que qualquer pessoa com o link possa realizar novos cadastros.

# Extra
Para testar a API utilizei o Insomnia. Caso deseje utiliza-lo também, faça o download pelo [link](https://insomnia.rest/). 
