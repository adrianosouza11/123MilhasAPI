# Projeto Grupo de Voos API 123Milhas  

A API 123Milhas foi desenvolvido em PHP utilizando o framework **Lumen**.
Sendo um projeto API Rest foi necessário o seu desenvolvimento utilizando do framework **Lumen**.
<p> O <b>Lumen</b> é um framework baseado em Laravel tendo seu objetivo no desenvolvimento de API's, por esse sentido 
e composição foi escolhido para o desenvolvimento deste sistema. </p>

## Composição de projeto

- A versão do PHP deve ser o 7.3 ou superior, pois o projeto utiliza o types declarations e outras peculiaridades da <br>
  versão
- Extensões que devem ser habilitadas cumprindo a exigência de framework e bibliotecas: **OpenSSL**, **PDO PHP**, <br>
  **Mbstring** e **cURL**.  
- Composer >= 1.6
- Apache 2 ou Ngnix
- Caso o servidor web seja Apache deve manter a exigência da reescrita de URI's como também utilização do htaccess  

## Das informações do gerenciador de pacotes Composer

O Composer vai trabalhar baixando os pacotes listados dentro do arquivo de configuração **composer.json** e deixando os <br>
pacotes equiparados com **composer.lock**. Abaixo listo alguns pacotes notáveis na composição do projeto:
- Lumen Framework (7.2.2) (Laravel Components ^7.0)
- OpenAPI ( zircote/swagger-php)
- Guzzle ^6.3.1|^7.0.1

## Biblioteca zircote/swagger-php

Como no repositório oficial do pacote, zircote/swagger-php é um gerador interativo que utiliza o Doctrine Annotations como padrão na 
<br>compilação de anotações inseridas pelo desenvolvedor resultando em um arquivo _.yaml_. Fonte: https://github.com/zircote/swagger-php

As anotações são especificadas em routes/web.php onde além das rotas que são inseridas faço a documentação da URI <br>
caracterizada utilizando o padrão Doctrine Annotation com OpenAPI. Segue o exemplo abaixo:

 ```
 /**
      * @OA\Get(
      *     path="/flights",
      *     summary="API que retorna todos os voos disponíveis ordenado em grupo",
      *     tags={"encontrar-voos"},
      *   @OA\Response(
      *      response=200,
      *      description="Resposta do recurso",
      *  )
      * )
 */
 Route::get('flights', 'FlightController@findAllFlights');
```

Após informado em routes/web.php o diretório swagger/exec contém o arquivo swagger.sh um script em shell executado via 
<br> terminal de preferência. O arquivo shell representa a forma de execução da compilação do arquivo binário OpenAPI e 
<br> localização de entrada de dados já especificado e a saída feita em swagger/data  onde o arquivo openapi.yaml é <br> 
gerado.

Exemplo de execução:

`vagrant@vagrant:/var/www/html/123MilhasAPI/swagger/exec$ ./swagger.sh`

O arquivo gerado em .yaml vai ser requisitado pelo pacote swagger em public/assets/swagger. O pacote tem como resultado 
<br> um conteúdo renderizado na página inicial acionada. A especificação da view em questão está localizada em <br> 
resource/views/site/index.php.

É importante a especificação do local do .yaml gerado no arquivo environment .env localizado na raíz do projeto. O <br>
_.yaml_ gerado está localizado em: _raiz_do_projeto_/swagger/data.

## Parâmetro especificados no arquivo de ambiente .env

API_123MILHAS_URL=http://prova.123milhas.net/api
API_URL_YAML=http://localhost/123MilhasAPI/swagger/data/openapi.yaml

**Observação:** renomei o arquivo **.env.example** para **.env** apenas.

## Site em ambiente de produção para teste da API com documentação Swagger

Foi publicado no seguinte URL abaixo a documentação Swagger como site para requisição da busca de todos os voos disponíveis.

Site API: http://api.adriano.logcomsolucoes.com.br/123milhas-api

Requisição de voos: http://api.adriano.logcomsolucoes.com.br/123milhas-api/api/v1/flights (documentado procedimento no site acima)