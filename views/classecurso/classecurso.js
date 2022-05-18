const AppTemplate = `

<div id="background">
  <div id="title">
    Gerenciamento de Classes de Cursos
  </div>

  <div>
    
      <div class="q-pa-md" align="center">
        <q-form
          @submit="insert"
          @reset="onReset"
          class="q-gutter-md"
        >

          <div class="row op1">
            <div id="divAno">
              <q-input
                filled
                v-model="classe.ano"
                label="Ano"
              />
            </div>  

            <q-input
              filled
              v-model="classe.semestre"
              label="Semestre"
            />
          </div>

          <div class="row op2">
            <q-input
              filled
              v-model="classe.turma"
              label="Turma"
            />

            <q-input
              filled
              v-model="classe.idcategoriapaimoodle"
              label="Categoria Pai Moodle"
            />
          </div>

        <div class="row op3">
          <q-select
            filled
            v-model="classe.codtipocurso"
            :options="predefinidas"
            option-value="tipo" 
            option-label="nome" 
            label="Tipo Curso"
            map-options
          />

          <q-select 
            filled 
            v-model="classe.codcurso"
            :options="options" 
            option-value="codcurso" 
            option-label="nomecurso" 
            label="Curso Livre"
            map-options
            />

            <q-select
            filled
            v-model="classe.termo"
            :options="predefinidas2"
            option-value="tipo" 
            option-label="nome" 
            label="Termo"
            map-options
          />
            
        </div>

        <div class="row op4">
            <div id="divDesc">
              <q-input
                filled
                v-model="classe.descricao"
                label="Descrição"
              />
            </div>
          
          </div>

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

        <q-table/>
      </div>

</div>`;

const CustomButton = {
    template: AppTemplate,
    data: function() {
        return {
            options: [],
            predefinidas: [
                { tipo: 1, nome: "Graduação" }, { tipo: 2, nome: "Pós-Graduação" },
            ],
            predefinidas2: [
                { tipo: 1, nome: '1º' }, { tipo: 2, nome: '2º' }, { tipo: 3, nome: '3º' }, { tipo: 4, nome: '4º' }, { tipo: 5, nome: '5º' }, { tipo: 6, nome: '6º' }, { tipo: 8, nome: '8º' }, { tipo: 9, nome: '9º' }, { tipo: 10, nome: '10º' }
            ],
            columns: [
                { align: 'center', label: 'Ano', field: 'ano', sortable: true, style: 'max-width: 0px' },
                { align: 'center', label: 'Semestre', field: 'semestre', sortable: true, style: 'max-width: 0px' },
                { align: 'center', label: 'Descrição', field: 'descricao', style: 'max-width: 0px' },
                { align: 'center', label: 'Termo', field: 'termo', style: 'max-width: 0px' },
                { align: 'center', label: 'Turma', field: 'turma', style: 'max-width: 0px' },
                { align: 'center', label: 'Id Categoria Pai Moodle', field: 'idcategoriapaimoodle', style: 'max-width: 0px' },
                { align: 'center', label: 'Tipo de Curso', field: 'codtipocurso', style: 'max-width: 0px' },
                { align: 'center', label: 'Curso', field: 'codcurso', style: 'max-width: 0px' },
                { name: 'edit', field: 'edit', style: 'max-width: 0px' },
                { name: 'del', field: 'del', style: 'max-width: 0px' }
            ],
            rows: [],
            classe: {
                ano: null,
                semestre: null,
                descricao: null,
                termo: null,
                turma: null,
                idcategoriapaimoodle: null,
                codtipocurso: null,
                codcurso: null
            },
            nomeBotao: 'Inserir',
            editando: 0,
            filter: ''
        }
    },
    components: {},
    methods: {
        listaClasse() {
            axios.post(BASEURL + "/classecurso/listaClasse").then((res) => {
                this.rows = res.data
            })
        },
        selectCurso() {
            axios.post(BASEURL + "/classecurso/selectCurso").then((res) => {
                this.options = res.data
            })
        },
        insert() {
            if (this.editando == 0) {
                if (this.classe.ano && this.classe.semestre && this.classe.descricao && this.classe.termo && this.classe.turma && this.classe.idcategoriapaimoodle && this.classe.codtipocurso && this.classe.codcurso) {
                    axios.post(BASEURL + "/classecurso/insert", this.classe).then((res) => {
                        alert(res.data.texto)
                        this.listaClasse()
                        this.reset()
                    })
                } else {
                    alert('Preencha Todos os campos!')
                }
            } else {
                if (confirm("Salvar Alteração?")) {
                    axios.post(BASEURL + "/classecurso/save", this.classe).then(res => {
                        alert(res.data.texto)
                        if (res.data.codigo == "1") {
                            this.listaClasse()
                            this.reset()
                            this.editando = 0
                        }
                    })
                }
            }
        },
        del(val) {
            if (confirm("Confirma Exclusão?")) {
                deleteItem(BASEURL + "/classecurso/del", val).then(res => {
                    alert(res.data.texto)
                    if (res.data.codigo == "1") {
                        this.listaClasse()
                    }
                })
            }
        },
        loadData(val) {
            axios.post(BASEURL + "/classecurso/loadData", val).then((res) => {
                this.classe = res.data
                console.log(res.data)
                this.editando = 1
            })
        },
        reset() {
            this.classe = {
                ano: null,
                semestre: null,
                descricao: null,
                termo: null,
                turma: null,
                idcategoriapaimoodle: null,
                codtipocurso: null,
                codcurso: null
            }
        },
    },
    mounted: function() {
        this.listaClasse()
        this.selectCurso()
    },
    watch: {}
}