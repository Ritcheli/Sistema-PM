# SOAR

Protótipo de um sistema desenvolvido através da parceria entre a Universidade Federal de Santa Catarina (UFSC) e o 19 Batalhão da Polícia Militar de Araranguá, com o objetivo de oferecer ferramentas de auxílio no gerenciamento dos dados provenientes das ocorrências polícias recebidos pela unidade e nas tomadas de decisão por parte dos profissionais de inteligência, utilizando a **Teoria de Análise de Redes Sociais (ARS)** para detecção de padrões em diferentes tipos de ocorrências. O sistema ainda conta com um mecanismo de importação de ocorrências através da leitura de PDF's de ocorrências policiais.

# Ferramentas utilizadas

O sistema foi desenvolvido utilizando os frameworks **Laravel** e **Bootstrap** para a criação dos códigos de Frontend e Backend e para o desenvolvimento dos grafos referentes às redes sociais identificadas pelo sistema, foi utilizado a biblioteca **Cytoscape Js**. Abaixo serão listados todos as ferramentas utilizadas bem como suas versões.

- **Composer:** 2.6.6
- **Laravel:** 10.6.2
- **Bootstrap:** 4.6
- **Python:** 3.12.1
- **PyMuPDF:** 1.23.5
- **MySQL:** 8.2.0 

# Instruções executar o sistema

Após a instação de todas as dependências citadas e a configuração do banco de dados, é necessário executar dois prompts de comando na **pasta do sistema em que o software está localizado**. No primeiro prompt é necessário executar o comando:

<p align="center">
**php artisan serve**
</p>

Pare executar e preparar o ambiente Laravel. Já no segundo prompt execute o seguinte comando:

<p align="center">
**npm run dev**
</p>

Para executar o Vite. Mais detalhes sobre o funcionamento destes comandos podem ser encontratos na documentação do Laravel e do Vite.
