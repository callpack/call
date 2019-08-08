# Funcionalidades (features)
1. baixar pacotes da organização [Basic](https://github.com/basicpack)
2. fazer o cache dos pacotes
3. instalar os pacotes
4. atualizar os pacotes
5. remover os pacotes
6. incorporar os pacotes facilmente através da função inc()

# Instalação
```bash
rm -rf ~/.config/basic &&
cd ~/.config &&
git clone https://github.com/basicpack/basic.git &&
cd ~/.config/basic &&
sudo rm -rf /usr/bin/basic &&
sudo ln -s ~/.config/basic/basic.php /usr/bin/basic &&
chmod +x /usr/bin/basic
```

# Como usar
Execute o comando no terminal:
```bash
basic [comando] [nome do pacote]
```
Por exemplo, para instalar o pacote de exemplo:
```bash
basic install test
```
Então adicione o seguinte código ao PHP:
```php
<?php
require 'basic/basic.php';
inc([
    'test'    
]);
test();//função pronta para ser usada
```

## Comandos
- help - Mostra a tela de ajuda
- install - Instala o(s) pacote(s)
- remove - Remove o(s) pacote(s)
- uninstall - Remove o(s) pacote(s)
- update - Atualiza o(s) pacote(s)

## Idéias em aberto
- Instalar pacotes públicos de terceiros
- Instalar pacotes privados
