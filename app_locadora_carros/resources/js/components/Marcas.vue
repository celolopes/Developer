<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Início do card de Busca -->
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col-sm-6">
                                <input-container-component titulo="ID" id="inputId" idHelp="idHelp" texto-ajuda="Opcional Informe o ID da marca.">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id" @keyup.enter="pesquisar">    
                                </input-container-component>
                            </div>
                            <div class="col-sm-6">
                                <input-container-component titulo="Nome da marca" id="inputNome" idHelp="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca.">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca" v-model="busca.nome" @keyup.enter="pesquisar">
                                </input-container-component>
                            </div> 
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-end" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de Busca -->

                <!-- Início do card de Listagem de marcas --> 
                <card-component titulo="Relação de Marcas">
                    <template v-slot:conteudo>
                        <table-component 
                            :dados="marcas.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar' }"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaAtualizar'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'text'},
                                nome: {titulo: 'Nome', tipo: 'text'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Data de criação', tipo: 'data'}
                            }"
                        ></table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row align-items-center">
                            <div class="col-6 text-center">
                                <paginate-component>
                                    <li v-for="l, key in marcas.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalMarca">Adicionar</button>
                            </div>
                        </div>
                    </template>    
                </card-component>    
                <!-- Fim do card de Listagem de marcas -->    
            </div>
        </div>
        <!-- Modal -->
        <modal-component id="modalMarca" titulo="Adicionar Marca">

            <template v-slot:alertas>
                <alert-component tipo="success" v-if="transacaoStatus == 'adicionado'" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com Sucesso!"></alert-component>
                <alert-component tipo="danger" v-if="transacaoStatus == 'erro'" :detalhes="transacaoDetalhes" titulo="Erro ao tentar carregar a Marca!"></alert-component>
            </template>

            <template v-slot:header>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Fechar"></button>
            </template>    
            
            <template v-slot:body>
                <div class="form-group mb-3">
                    <input-container-component titulo="Nome da marca" id="novoNome" idHelp="novoNomeHelp" texto-ajuda="Informe o nome da marca.">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca" v-model="nomeMarca">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImage" idHelp="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato JPG, JPEG e PNG.">
                        <br>
                        <input type="file" class="form-control-file" id="novoImage" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>
            
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        
        
        <!-- Modal visualização de marcas -->
        <modal-component id="modalMarcaVisualizar" titulo="Visualizar Marca">
            <template v-slot:alertas></template>
            <template v-slot:header>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Fechar"></button>
            </template>
            <template v-slot:body>
                <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                <input-container-component titulo="Nome da marca">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>
                <input-container-component titulo="Imagem da marca">
                    <img :src="'/storage/'+ $store.state.item.imagem" v-if="$store.state.item.imagem" :alt="$store.state.item.nome">
                </input-container-component>
                <input-container-component titulo="Nome da marca">
                        <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </input-container-component>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        
        <!-- Modal de remoção de marcas -->
        <modal-component id="modalMarcaRemover" titulo="Remover Marca">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:header>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Fechar"></button>
            </template>
            <template v-slot:body v-if="$store.state.transacao.status !== 'sucesso'">
                <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                <input-container-component titulo="Nome da marca">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" v-if="$store.state.transacao.status !== 'sucesso'" @click="remover($store.state.item.id)">Remover</button>
            </template>
        </modal-component>

        <!--Inicio do Modal de Edição -->
        <modal-component id="modalMarcaAtualizar" titulo="Atualizar Marca">

        <template v-slot:alertas>
            <alert-component tipo="success" titulo="Transação realizada com Sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'" ></alert-component>
            <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
        </template>

        <template v-slot:header>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Fechar"></button>
        </template>    

        <template v-slot:body>
            <div class="form-group mb-3" v-if="$store.state.transacao.status !== 'sucesso'">
                <input-container-component titulo="Nome da marca" id="alteraNome" idHelp="alteraNomeHelp" texto-ajuda="Informe o nome da marca.">
                    <input type="text" class="form-control" id="alteraNome" aria-describedby="alteraNomeHelp" placeholder="Nome da marca" v-model="$store.state.item.nome">
                </input-container-component>
            </div>

            <div class="form-group">
                <input-container-component titulo="Imagem" id="alteraImage" idHelp="alteraImagemHelp" texto-ajuda="Selecione uma imagem no formato JPG, JPEG e PNG.">
                    <br>
                    <input type="file" class="form-control-file" id="alteraImage" aria-describedby="alteraImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                </input-container-component>
            </div>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" @click="atualizar()" v-if="$store.state.transacao.status !== 'sucesso'">Alterar</button>
        </template>
        </modal-component> 

    </div>
</template>

<script>
    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/marca',
                urlPaginacao: '',
                urlFiltro: '',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                marcas: { data: [] },
                busca: { id: '', nome: '' },
            }
        },
        methods: {
            pesquisar() {
                // Adiciona '%' apenas para o campo busca.nome
                if (this.busca.nome !== '') {
                    this.busca.nome = '%' + this.busca.nome + '%';
                }

                let filtro = '';
                for(let chave in this.busca) {
                    if (this.busca[chave] == '') {
                        continue;
                    }
                    if (filtro != '') {
                        filtro += ';';
                    }
                    filtro = filtro + chave + ':like:' + this.busca[chave];
                }
                if (filtro!= '') {
                    this.urlPaginacao = 'page=1';
                    this.urlFiltro = '&filtro=' + filtro;
                } else {
                    this.urlFiltro = '';
                }
                console.log(filtro);

                this.carregarLista();
            },
            remover(id) {
                let confirmacao = confirm('Tem certeza que deseja remover a marca?');

                if (!confirmacao) {
                    return false;
                }

                if (confirmacao) {
                    this.transacaoStatus = '';
                    this.transacaoDetalhes = {};

                    axios.delete(this.urlBase + '/' + id)
                    .then(response => {
                        this.transacaoStatus = 'removido';
                        this.transacaoDetalhes = response.data;
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = response.data.msg;
                        this.carregarLista();

                    })    
                    .catch (errors => {
                        this.transacaoStatus = 'erro';
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = errors.response.data.erro;
                        this.transacaoDetalhes = errors.response.data;
                        console.log(errors.response.data);
                    })
                }    
            },
            atualizar() {

                let formData = new FormData();
                formData.append('_method', 'patch');
                formData.append('nome', this.$store.state.item.nome);

                if (this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0]);
                }

                let $url = this.urlBase + '/' + this.$store.state.item.id;

                let config = {
                    headers: {
                        'Content-Type':'multipart/form-data',
                    }
                }

                axios.post($url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = 'Registro de marca atualizado com sucesso!';

                        console.log('Atualizado', response);
                        //limpar o campo de seleção da imagem
                        alteraImage.value = '';
                        this.carregarLista();
                    })
                    .catch (errors => {
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = errors.response.data.message;
                        this.$store.state.transacao.dados = errors.response.data.erros;

                        console.log('Erro de atualização', errors.response.data);
                    })    
                
            },     
            paginacao(l) {
                if (l.url) {
                    //this.urlBase = l.url;
                    this.urlPaginacao = l.url.split('?')[1];
                    if (l.url.split('?')[2]) {
                        this.urlFiltro = l.url.split('?')[2];
                    }    
                    console.log(this.urlPaginacao);
                    console.log(this.urlFiltro);

                    this.carregarLista();
                } 
            },
            carregarLista() {
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro;
                console.log(url);
                axios.get(url)
                .then(response => {
                    this.marcas = response.data;
                })    
                .catch (errors => {
                    this.marcas = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                    console.log(errors);
                })
            },
            carregarImagem(e) {
                this.arquivoImagem = e.target.files;
            },
            salvar() {
                console.log(this.nomeMarca, this.arquivoImagem[0]);

                let formData = new FormData();
                formData.append('nome', this.nomeMarca);
                formData.append('imagem', this.arquivoImagem[0]);

                let config = {
                    headers: {
                        'Content-Type':'multipart/form-data'
                    }
                }

                axios.post(this.urlBase, formData, config)
                     .then(
                        response => {
                            this.transacaoStatus = 'adicionado';
                            this.transacaoDetalhes = {
                                mensagem: 'ID do Registro: ' + response.data.id
                            }
                            this.carregarLista();
                            console.log(response); // Emite um evento para fechar o modal
                        }
                     ).catch(errors => {
                        this.transacaoStatus = 'erro';
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }
                     })
            }
        },
        mounted() {
            this.carregarLista();
        }
    }
   
</script>