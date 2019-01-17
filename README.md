# instalação
    git clone https://github.com/getbasic/basic.git ~/.config

Adicione um alias para o script basic.php:

    alias basic="php ~/.config/basic/basic.php"

# funcionalidades (features)
1. baixar pacotes (meus repositórios)
2. fazer o cache dos pacotes
3. instalar os pacotes
4. atualizar os pacotes
5. remover os pacotes
6. incorporar os pacotes facilmente através da função inc()

# TODO
## uninstall
    verifica se o pacote existe no "{$PWD}basic/basic.json
    apaga a pasta do pacote em "{$PWD}basic/$repo"
    apaga o registro do pacote no $PWD/basic/basic.json
