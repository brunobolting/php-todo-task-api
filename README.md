# Sobre o projeto
O projeto foi feito como forma de estudo, o foco foi treinar o uso de Clean Architecture e também testar o uso do DoctrineORM como repositório.

O projeto é relativamente bem simples, basicamente um CRUD com interface REST. As dificuldades que tive com o projeto envolvem mais o framework e o ORM. Dou destaque para duas:

1. o body parser do Symfony, onde precisei criar uma classe específica para fazer o parse do json, pois em alguns casos, dependendo do formato usado para transmitir os dados, a versão nativa do framework não estava funcionando como eu gostaria;
2. criar e configurar um campo uuid custom para ser usado no banco de dados com Symfony e DoctrineORM. Deu um certo trabalho achar exemplos de como implementar essa funcionalidade e configurar, pois eu precisava converter meu ID antes de retornar, por isso precisaria criar essa função manualmente.

# Como rodar o projeto
Para rodar o projeto basta seguir os passos abaixo:

1. `composer install`
2. `php -S localhost:8000 -t public`
