# Funcionalidades (features)
1. baixar pacotes (meus repositórios)
2. fazer o cache dos pacotes
3. instalar os pacotes
4. atualizar os pacotes
5. remover os pacotes
6. incorporar os pacotes facilmente através da função inc()

# Instalação
    git clone https://github.com/getbasic/basic.git ~/.config/basic &&
    cd ~/.config/basic &&
    composer install &&
    sudo ln -s ~/.config/basic/basic.php /usr/bin/basic &&
    chmod +x /usr/bin/basic

# Como usar
```
basic [nome do comando] [nome do pacote]
```
## Nomes dos comandos
- install - Instala um pacote
- remove - Remove um pacote
- uninstall - Remove um pacote
- update - Atualiza um pacote
