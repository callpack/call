# local
cd ~/.config/basic

# funcionalidades (features)
1. baixar pacotes (meus repositórios)
2. fazer o cache dos pacotes
3. instalar os pacotes
4. atualizar os pacotes
5. remover os pacotes
6. incorporar os pacotes facilmente através da função inc()

# download
    [x] adicionar argumento para receber o user-agent

# help
    ok instruções de uso

# install
    ok adicionar o parametro $skipCache
    ok verifica se ele existe no cache
        ok existe no cache
            ok lê
        ok não existe no cache
            ok baixa
            ok lê
            ok salva
    ok extrai o arquivo do cache no "{$PWD}basic/$repo";
    ok salva no $PWD.'basic/basic.json'

# uninstall
    verifica se ele existe no "{$PWD}basic/basic.json
    apaga a pasta dele em "{$PWD}basic/$repo"
    apaga o registro dele no $PWD/basic/basic.json

#unzip
    ok descompacta o arquivo

#update
    ok install com $skipCache ativado
