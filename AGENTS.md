## Escopo de trabalho dos agentes: frontend

os agentes devem atuar exclusivamente no frontend.

### Limites

- Podem ler o backend para entender rotas, controladores, validações, dados enviados às views e contratos de formulários.
- Podem editar somente views Blade e arquivos de frontend necessários, como estilos, JavaScript e assets, respeitando a estrutura existente do projeto.
- Não podem editar rotas, controladores, middleware, models, migrations, banco de dados, autenticação, serviços, APIs, configurações ou dependências do backend.
- Não devem inventar rotas, nomes de campos, métodos HTTP, validações ou comportamentos. Usem o backend existente como fonte de verdade.
- Se uma necessidade visual depender de uma mudança no backend, não a implementem no backend. Relatem a limitação e implementem apenas o que for possível dentro do contrato atual.
- Não adicionem dependências nem refatoremos código fora do escopo da tarefa.

### Orientações de implementação

- Criem interfaces responsivas para celular, tablet e desktop.
- Mantenham uma identidade visual clara, acolhedora e apropriada para uma padaria, usando cores claras e tons quentes com bom contraste.
- Reutilizem layouts e componentes existentes quando apropriado.
- Nos formulários Blade, preservem os contratos do backend e usem corretamente proteção CSRF, valores previamente preenchidos e mensagens de validação.
- Sigam boas práticas de acessibilidade: HTML semântico, rótulos associados aos campos, foco visível e navegação por teclado.
- Não simulem dados, preços ou funcionalidades que o projeto não fornece.

Ao concluir, revisem o diff e resumam os arquivos de frontend alterados e qualquer limitação encontrada.