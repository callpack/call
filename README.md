# Gerenciador de pacotes procedurais PHP
## Funcionalidades (features)
1. Baixar pacotes da organização [Basic](https://github.com/basicgnomo)
2. Fazer o cache local dos pacotes
3. Instalar os pacotes
4. Atualizar os pacotes
5. Remover os pacotes
6. Incorporar os pacotes facilmente através da função inc()

## Instalação
```bash
rm -rf ~/.config/basic &&
cd ~/.config &&
git clone https://github.com/basicpack/basic.git &&
cd ~/.config/basic &&
sudo rm -rf /usr/bin/basic &&
mkdir ~/.config/basic/cache &&
sudo chmod 777 -R ~/.config/basic/cache &&
sudo ln -s ~/.config/basic/basic.php /usr/bin/basic &&
chmod +x /usr/bin/basic
```

## Como usar
Execute o comando no terminal:
```bash
basic [comando] [nome do(s) pacote(s)]
```
Por exemplo, para instalar o pacote de exemplo:
```bash
basic install test
```
Então adicione o código de incorporação ao PHP:
```php
<?php
require 'basic/basic.php';
inc([
    'test'    
]);
test();//função pronta para ser usada
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
