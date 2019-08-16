# Gerenciador de pacotes HMVC em PHP
Baseado no código fonte do [Basic v0.1.0](https://github.com/basicpack/basic/releases/tag/0.1.0).

## Funcionalidades (features)
1. Baixar pacotes da organização [Call](https://github.com/callgnomo)
2. Fazer o cache local dos pacotes
3. Instalar os pacotes
4. Atualizar os pacotes
5. Remover os pacotes
6. Incorporar os pacotes facilmente através da função controller()

## Instalação
```bash
rm -rf ~/.config/basic &&
cd ~/.config &&
git clone https://github.com/callpack/call.git &&
cd ~/.config/call &&
sudo rm -rf /usr/bin/call &&
mkdir ~/.config/call/cache &&
sudo chmod 777 -R ~/.config/call/cache &&
sudo ln -s ~/.config/call/call.php /usr/bin/call &&
chmod +x /usr/bin/call
```

## Como usar
Execute o comando no terminal:
```bash
call [comando] [nome do(s) pacote(s)]
```
Por exemplo, para instalar o pacote de exemplo:
```bash
call install teste
```
Então adicione o código de incorporação ao PHP:
```php
<?php
require 'basic/basic.php';
inc([
    'controller'    
]);
controller('teste/home');
```

### Comandos
- help - Mostra a tela de ajuda
- install - Instala o(s) pacote(s)
- remove - Remove o(s) pacote(s)
- uninstall - Remove o(s) pacote(s)
- update - Atualiza o(s) pacote(s)

### Idéias em aberto
- Instalar pacotes públicos de terceiros
- Instalar pacotes privados
- Migração de tabelas
