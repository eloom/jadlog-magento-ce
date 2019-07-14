# Jadlog Frete para Magento

Integração com sistema de fretes da Jadlog através do sistema [Getmodal](http://www.getmodal.com.br).

## Recursos

- [x] cotação de fretes

- [x] rastreamento da encomenda pelo painel da Loja Magento

- [x] opção de informar frete grátis

- [x] opção de exibir/ocultar o prazo de entrega

- [x] taxa extra em valor ou percentual

- [x] mapeamento dos campos de peso, largura, altura e comprimento

- [x] prazo extra, em dias, somandos ao prazo recebido da Jadlog

- [x] gravação das requisicões e respostas em arquivo de log

- [x] todos os recursos que o [Getmodal](http://www.getmodal.com.br) oferece

## Requisitos

- [x] ter convênio firmado com a Jadlog atráves de um franqueado.

- [x] ter convênio firmado com o [Getmodal](http://www.getmodal.com.br). Fale com seu franqueado Jadlog e veja se ele já tem convênio firmado.

## Perguntas Frequentes


## Dependências


O módulo de frete Jadlog com [Getmodal](http://www.getmodal.com.br) para Magento precisa do módulo [Bootstrap para Magento CE](https://github.com/eloom/bootstrap-magento-ce)


## Compatibilidade

- [x] Magento 1.9.3.x

- [x] PHP/PHP-FPM 5.6

## Começando

Os projetos da élOOm utilizam o [Apache Ant](https://ant.apache.org/) para publicar o projeto nos ambientes de **desenvolvimento** e de **teste** e para gerar os pacotes para o **ambiente de produção**.

- Publicando no **ambiente local**

	- no arquivo **build-desenv.properties**, informe o path do **Document Root** na propriedade "projetos.path";
	
	- na raiz deste projeto, execute, no prompt, o comando ```ant -f build-desenv.xml```.
	
	
	> a tarefa Ant irá copiar todos os arquivos do projeto no seu Magento e limpar a cache.
	

- Publicando para o **ambiente de produção**

	- na raiz deste projeto, execute, no prompt, o comando ```ant -f build-producao.xml```.
	
	
	> a tarefa Ant irá gerar um pacote no formato .zip, no caminho definido na propriedade "projetos.path", do arquivo **build-producao.properties**.

	> os arquivos .css e .js serão comprimidos automáticamente usando o [YUI Compressor](https://yui.github.io/yuicompressor/).
	

## Release Notes

### [1.0.0] - 2018-04-30

#### Versão inicial