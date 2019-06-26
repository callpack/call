# Funcionalidades (features)
1. baixar pacotes da organização [BASIC](https://github.com/getbasic)
2. fazer o cache dos pacotes
3. instalar os pacotes
4. atualizar os pacotes
5. remover os pacotes
6. incorporar os pacotes facilmente através da função inc()

# Instalação
```bash
rm -rf ~/.config/basic &&
cd ~/.config &&
git clone https://github.com/getbasic/basic.git &&
cd ~/.config/basic &&
composer install &&
sudo rm -rf /usr/bin/basic &&
sudo ln -s ~/.config/basic/basic.php /usr/bin/basic &&
chmod +x /usr/bin/basic
```

# Como usar
```bash
basic [comando] [nome do pacote]
```
## Comandos
- install - Instala um pacote
- remove - Remove um pacote
- uninstall - Remove um pacote
- update - Atualiza um pacote
