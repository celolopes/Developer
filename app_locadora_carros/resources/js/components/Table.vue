<template>
    <div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-for="t, key in titulos" :key="key" scope="col">{{t.titulo}}</th>
                <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel" colspan="3">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                <td v-for="valor, chaveValor in obj" :key="chaveValor">
                    <span v-if="titulos[chaveValor].tipo == 'text'">{{ valor }}</span>
                    <span v-if="titulos[chaveValor].tipo == 'data'">{{ valor | formatDataTempoGlobal }}</span>
                    <span v-if="titulos[chaveValor].tipo == 'imagem'">
                        <img :src="'/storage/'+valor" width="30" height="30">
                    </span>
                </td>
                <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                    <button v-if="visualizar.visivel" type="button" class="btn btn-outline-primary btn-sm" :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget" @click="setStore(obj)">Visualizar</button>
                    <button v-if="atualizar.visivel" type="button" class="btn btn-outline-primary btn-sm" :data-toggle="atualizar.dataToggle" :data-target="atualizar.dataTarget" @click="setStore(obj)">Atualizar</button>
                    <button v-if="remover.visivel" type="button" class="btn btn-outline-danger btn-sm" :data-toggle="remover.dataToggle" :data-target="remover.dataTarget" @click="setStore(obj)">Remover</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'atualizar', 'visualizar', 'remover'],
        methods: {
            formatarData(data) {
                // Verifica se a data é válida
                if (data instanceof Date && !isNaN(data)) {
                    // Formata a data para o formato d/m/Y
                    return data.toLocaleDateString('pt-BR');
                }
                return data; // Retorna a data original se não for válida
            },
            setStore(obj) {
                this.$store.state.transacao.status = '';
                this.$store.state.transacao.mensagem = '';
                this.$store.state.transacao.dados = '';
                this.$store.state.item = obj;
            }
        },
        computed: {
            dadosFiltrados() {
                let campos = Object.keys(this.titulos);
                let tipos = Object.values(this.titulos);
                let dadosFiltrados = [];
                this.dados.map((item, chave) => {
                    let itemFiltrado = {};
                    campos.forEach((campo, index) => {
                        if (tipos[index].tipo === 'data') {
                            // Verifica se o valor pode ser convertido em uma data
                            const data = new Date(item[campo]);
                            if (!isNaN(data.valueOf())) {
                                // Se for uma data válida, formata para d/m/Y
                                itemFiltrado[campo] = this.formatarData(data);
                            } else {
                                // Se não for uma data válida, mantém o valor original
                                itemFiltrado[campo] = item[campo];
                            }
                        } else {
                            itemFiltrado[campo] = item[campo];
                        }
                    })
                    dadosFiltrados.push(itemFiltrado);    
                })
                return dadosFiltrados;
            }
        }
    }
</script>