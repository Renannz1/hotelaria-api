# 🏨 Sistema de Gerenciamento Hoteleiro 🏨

## Bem-vindo ao meu projeto de gerenciamento hoteleiro! 😊

Este projeto é um sistema de gerenciamento hoteleiro, desenvolvido para facilitar a administração de estabelecimentos. O sistema possui controle de reservas, hóspedes e serviços, tornando a gestão mais eficiente. 📊

## Principais Funcionalidades 🎯

### Reservas 💺
- Gerenciamento de reservas de quartos e serviços
- Controle de disponibilidade em tempo real 🕒

### Hóspedes 👥
- Manutenção de informações dos hóspedes
- Gestão de preferências e histórico de reservas 📝

### Quartos 🛏️
- Gerenciamento de quartos e tipos de acomodação
- Controle de status e disponibilidade

### Cupons de Desconto 🎁
- Criação e gerenciamento de cupons promocionais
- Ativação e inativação de cupons específicos

## Tecnologias Utilizadas 🔧

- PHP 8.1+
- Composer 💼
- Laravel 11 🌟
- Swagger 📚
- MySQL 🐙

## Como Funciona? 🤔

1. **Modelagem do Banco de Dados**:
   - Estruturação do banco de dados com base nos arquivos XML fornecidos 📊

2. **Desenvolvimento em PHP**:
   - Implementação de um script para recuperação de dados de arquivos XML e persistência no banco de dados 💻

3. **API REST**:
   - Implementação de operações CRUD para quartos, hotéis e reservas 🔧
   - Criação de endpoints para gerenciamento de cupons de desconto 🎁

4. **Documentação**:
   - Elaboração da documentação das rotas utilizando Swagger 📚

## Modelo do Banco de Dados 🖼️
[Clique aqui](/arquivos/diagrama.png) para baixar o diagrama de classe do projeto.

## Como Instalar? 🛠️

## Passo a passo para instalação
1. Clone o repotório
   - Utilize o seguinte código para clonar o repositório:
    ```bash
    git clone https://github.com/Renannz1/teste-foco-api
    ```

3. Instale o Composer:
   - É necessário instalar as dependencias do projeto utlizando:
    ```bash
    composer install
    ```

4. Configure o arquivo `.env`:
   - Após clonar o repositório, renomeie o arquivo .env.example para .env.
   - Abra o arquivo .env e configure as credenciais do banco de dados conforme necessário.
   - Crie um banco de dados no seu servidor de banco de dados (MySQL, PostgreSQL, etc.) correspondente ao que foi definido na configuração do .env. O comando para isso depende do sistema de gerenciamento de banco de dados em uso.
     
5. Execute as migrações para criar as tabelas no banco de dados:
```bash
php artisan migrate
```

5. Importar XMLs
   - [Clicando aqui](/arquivos/xml.rar) para baixar a pasta `xml` compactada com os arquivos xml.
   - Cole a pasta `xml` nesse diretórtio `storage/app/`.
   - Para importar os arquivos XML, execute o seguinte comando no terminal do projeto:
    ```bash
    php artisan command:import-xml-data storage/app/xml/hotels.xml storage/app/xml/reserves.xml storage/app/xml/rooms.xml
    ```

5. Para utilizar o Cron
   - Acessar o servidor
   - Conecte-se ao servidor onde a aplicação está hospedada para iniciar a configuração.
   - Abra o Crontab
   - No terminal, insira o seguinte comando para acessar o editor de agendamento de tarefas do sistema:
    ```bash
    sudo crontab -e
    ```
    - No final do arquivo insira o seguinte comando para executar o Cron, para que o script de importarção seja executado a cada 2 minutos.
   ```bash
    */2 * * * * /usr/bin/php /caminho/para/seu/projeto/artisan command:import-xml-data storage/app/xml/hotels.xml storage/app/xml/reserves.xml storage/app/xml/rooms.xml
   ```
   
6. Para executar as rotas:
    - As rotas a seguir são utilizadas para acessar diferentes recursos da API.
    - Execute as rotas usando o Postman ou Insominia.
    - Para acessar a documentação das rotas feito com swagger use a url:
    ```bash
    http://<sua_rota>/projeto_foco/public/api/documentation
    ```

## Endpoints da API 🌐

### Cupons
- GET|HEAD: `api/coupon`
- POST: `api/coupon`
- PUT: `api/coupon-off/{id_coupon}`
- PUT: `api/coupon-on/{id_coupon}`
- GET|HEAD: `api/coupon/{coupon}`
- PUT|PATCH: `api/coupon/{coupon}`
- DELETE: `api/coupon/{coupon}`

### Hotéis
- GET|HEAD: `api/hotel`
- POST: `api/hotel`
- GET|HEAD: `api/hotel/{hotel}`
- PUT|PATCH: `api/hotel/{hotel}`
- DELETE: `api/hotel/{hotel}`

### Reservas
- GET|HEAD: `api/reserve`
- POST: `api/reserve`

### Quartos
- GET|HEAD: `api/room`
- POST: `api/room`
- GET|HEAD: `api/room/{room}`
- PUT|PATCH: `api/room/{room}`
- DELETE: `api/room/{room}`
