const AppTemplate = `

<div id="background">
  <div id="title">
    Gerenciamento de Professores
  </div>

  <div>
    
      <div class="q-pa-md" align="center">
        <q-form
          id="formProfessor"
          @submit="insert"
          @reset="onReset"
          class="q-gutter-md"
        >
          <q-input
            filled
            v-model="professor.username"
            label="Usuário"
          />

          <q-select 
            filled 
            v-model="professor.cursolivre"
            :options="options"
            option-value="codcurso"
            option-label="nomecurso"
            label="Curso Livre"
            map-options
            />

          <q-input
            filled
            v-model="professor.nomecompleto"
            label="Nome Completo"
          />

          <q-input
            filled
            v-model="professor.criado"
            label="Criado"
          />

          <div>
            <q-btn :label="editando == 1?'Salvar':'Incluir'" type="submit" color="primary"/>
          </div>
        </q-form>

      </div>

      <div class="q-pa-lg">
        <q-table
        style="height: 400px"
        :rows="rows"
        :columns="columns"
        row-key="index"
        :filter="filter"
        virtual-scroll
        v-model:pagination="pagination"
        :rows-per-page-options="[0]"
      >

      <template v-slot:top-right>
        <q-input 
        borderless 
        dense 
        debounce="300" 
        v-model="filter" 
        placeholder="Pesquisar"
        >
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

          <template v-slot:body-cell-edit="props">
            <q-td :props="props">
            <q-btn
            color="primary"
            icon-right="edit"
            no-caps
            flat
            dense
            @click="loadData(props.row)"
            />
            </q-td>
          </template>

          <template v-slot:body-cell-del="props">
            <q-td :props="props">
            <q-btn
            color="negative"
            icon-right="delete"
            no-caps
            flat
            dense
            @click="del(props.row)"
            />
            </q-td>
          </template>

        </q-table>

      </div>

</div>`;

const CustomButton = {
    template: AppTemplate,
    data: function() {
        return {
            options: [],
            columns: [
                { align: 'center', label: 'Usuário', field: 'username', sortable: true, style: 'max-width: 0px' },
                { align: 'center', label: 'Curso Livre', field: 'nomecurso', sortable: true, style: 'max-width: 0px' },
                { align: 'center', label: 'Nome Completo', field: 'nomecompleto', style: 'max-width: 0px' },
                { align: 'center', label: 'Criado', field: 'criado', style: 'max-width: 0px' },
                { name: 'edit', field: 'edit', style: 'max-width: 0px' },
                { name: 'del', field: 'del', style: 'max-width: 0px' }
            ],
            rows: [],
            professor: {
                cursolivre: null,
                username: null,
                nomecurso: null,
                nomecompleto: null,
                criado: null
            },
            nomeBotao: 'Inserir',
            editando: 0,
            filter: ''
        }
    },
    components: {},
    methods: {
        listaProfessor() {
            axios.post(BASEURL + "/professor/listaProfessor").then((res) => {
                this.rows = res.data
            })
        },
        selectCurso() {
            axios.post(BASEURL + "/professor/selectCurso").then((res) => {
                this.options = res.data
            })
        },
        insert() {
            if (this.editando == 0) {
                if (this.professor.username && this.professor.cursolivre && this.professor.nomecompleto && this.professor.criado) {
                    axios.post(BASEURL + "/professor/addProfessor", this.professor).then((res) => {
                        alert(res.data.texto)
                        this.listaProfessor()
                        this.reset()
                    })
                } else {
                    alert('Preencha Todos os campos!')
                }
            } else {
                if (confirm("Salvar Alteração?")) {
                    axios.post(BASEURL + "/professor/save", this.professor).then(res => {
                        alert(res.data.texto)
                        if (res.data.codigo == "1") {
                            this.listaProfessor()
                            this.reset()
                            this.editando = 0
                        }
                    })
                }
            }
        },
        del(val) {
            if (confirm("Confirmar Exclusão?")) {
                axios.post(BASEURL + "/professor/del", val).then(res => {
                    alert(res.data.texto)
                    if (res.data.codigo == "1") {
                        this.listaProfessor()
                    }
                })
            }
        },
        loadData(val) {
            axios.post(BASEURL + "/professor/loadData", val).then((res) => {
                this.professor = res.data
                console.log(res.data)
                this.editando = 1
            })
        },
        reset() {
            this.professor = {
                cursolivre: null,
                username: null,
                nomecurso: null,
                nomecompleto: null,
                criado: null
            }
        }
    },
    watch: {},
    mounted: function() {
        this.listaProfessor()
        this.selectCurso()
    }
}