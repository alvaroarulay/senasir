<template>
   <main class="app-content">
        <div class="app-title row">
            <div class="col-md-8">
               <h1><i class="bi bi-collection"></i> Unidad: <p v-text="unidad"></p></h1> 
            </div>
            <div class="col-md-4">
                <select class="form-select" @change="onChangeUnidad($event)">
                    <option v-for="unidad in arrayUnidad" :value="unidad.id" v-text="unidad.descrip"></option>
                </select>
            </div>
            </div>
    <div class="tile">
        <h3 class="tile-title">Detalles del Grupo Contable</h3>
        <div class="tile-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3 row">
                    <label class="form-label col-md-3">Grupo</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" v-model="codcont">
                    </div>
                    </div>
                    <div class="mb-3 row">
                    <label class="form-label col-md-3">Vida Útil</label>
                    <div class="col-md-8">
                        <input class="form-control col-md-8" v-model="vidautil">
                    </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3 row">
                    <label class="form-label col-md-3">Grupo Contable</label>
                    <div class="col-md-8">
                        <select class="form-select" @change="onChangeCodigo($event)">
                            <option v-for="gcont in arrayContables" :value="gcont.id" v-text="gcont.nombre"></option>
                        </select>
                    </div>
                    </div>
                    <div class="mb-3 row">
                    <label class="form-label col-md-3">Observaciones</label>
                    <div class="col-md-8">
                        <textarea name="" id="" cols="30" rows="2" class="form-control col-md-8" v-model="observaciones"></textarea>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="row">
                <div class="col-md-10"><h3 class="tile-title">Detalle de Auxiliares</h3></div>
                <div class="col-md-2 bs-component d-grid mb-3">
                    <button type="submit" @click="abrirModal('auxiliar','registrar')" class="btn btn-primary btn-block"><i class="bi bi-plus-square"></i> Nuevo</button>
           </div>
            </div>
            
            <div class="tile-body table-responsive">
                 <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Código</th>
                            <th>Nombre Auxiliar</th>
                        </tr>
                    </thead>
                    <tbody v-if="arrayAuxiliar.length">
                        <tr v-for="auxiliar in arrayAuxiliar" :key="auxiliar.id">
                            <td>
                                <button type="button" @click="abrirModal('auxiliar','actualizar',auxiliar)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar">
                                  <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                            <td v-text="auxiliar.id"></td>
                            <td v-text="auxiliar.nomaux"></td>
                        </tr>                                
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="3">
                                NO hay Auxiliares en este Grupo
                            </td>
                        </tr>
                    </tbody>  
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
          </div>
        </div>
    </div> <!-- Fin ejemplo de tabla Listado -->
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close btn btn-danger btn-sm" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row mb-3">
                                    <label class="col-md-3" for="text-input">Grupo Contable:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="grupocontable" class="form-control" disabled>                       
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-3" for="text-input">Nombre Auxiliar:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nomaux" class="form-control">                                        
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-3" for="text-input">Observaciones:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="observ" class="form-control">                                        
                                    </div>
                                </div>
                                <div v-show="errorAuxiliar" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjAuxiliar" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" @click="cerrarModal()"><i class="bi bi-x-square"></i>Cerrar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="actualizarAuxiliar()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                <path d="M11 2H9v3h2z"/>
                                <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                                </svg>Actualizar
                            </button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarAuxiliar()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                <path d="M11 2H9v3h2z"/>
                                <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                                </svg>Guardar
                            </button>
                          </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
    </main>
</template>
<script>
import axios from 'axios';
export default {
  data() {
    return {
      id:0,
      nomaux:'',
      idunidad:1,
      unidad:'',
      vidautil:40,
      observaciones:'',
      observ:'',
      tituloModal:'',
      tipoAccion:0,
      grupocontable:'',
      codcont:1,
      arrayAuxiliar : [],
      arrayContables : [],
      arrayUnidad:[],
      modal : 0,
      errorAuxiliar : 0,
      errorMostrarMsjAuxiliar : [],
      pagination : {
          'total' : 0,
          'current_page' : 0,
          'per_page' : 0,
          'last_page' : 0,
          'from' : 0,
          'to' : 0,
      },
      offset : 3,
      criterio : 'nomaux',
      buscar : ''
    }
  },
  computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
  methods: {
    listarAuxiliar (page,id){
        let me=this;
        var url= '/auxiliar?page=' + page + '&id='+ id;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayAuxiliar = respuesta.auxiliares.data;
            me.pagination= respuesta.pagination;
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    listarContables (id){
        let me=this;
        var url= '/contable?id='+ id;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayContables = respuesta.codigos;
            me.detalleContable(this.codcont);
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    listarUnidad (){
        let me=this;
        var url= '/unidad/select';
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayUnidad = respuesta.unidad;
            me.listarContables(me.idunidad);
            me.listarAuxiliar(1,me.codcont);
    
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    detalleContable(idcont){
        const resultado = this.arrayContables.find((grupo) => grupo.id == idcont);
        console.log(resultado);
        this.vidautil= resultado.vidautil;
        this.observaciones= resultado.observ;
        this.grupocontable=resultado.nombre;
    },
    onChangeCodigo(event) {
        this.codcont=(event.target.value);
        this.detalleContable(this.codcont);
        this.listarAuxiliar(1,this.codcont);
    },
    onChangeUnidad(event){
        this.idunidad=(event.target.value);
        const res = this.arrayUnidad.find((unidad) => unidad.id == this.idunidad);
        this.unidad= res.descrip;
        this.listarContables(this.idunidad);
    },
    cambiarPagina(page,id){
        let me = this;
        me.pagination.current_page = page;
        me.listarAuxiliar(page,id);
    },
    abrirModal(modelo, accion, data = []){
        switch(modelo){
                    case "auxiliar":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Auxiliar';
                                this.nomaux='';
                                this.observ='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal = 'Actualizar Auxiliar';
                                this.id = data['id'];
                                this.nomaux=data['nomaux'];
                                this.codcont=data['codcont'];
                                this.codaux=data['codaux'];
                                this.tipoAccion=2;
                                break;
                            }
                        }
                    }
                }
     
    },
    cerrarModal(){
      this.modal=0;
    },
    actualizarAuxiliar(){
          let me = this;
          axios.put('/auxiliar/update',{
            'id':this.id,
            'nomaux':this.nomaux,
            'codcont':this.codcont,
            'codaux':this.codaux,
          }).then((response)=>{
              me.cerrarModal();
              Swal.fire(response.data.message,"","info");
              me.listarAuxiliar(1,'','nomaux');
          }).catch((error)=>{
            Swal.error('Hubo un Error');
              console.log(error);
          }); 
      },  
      registrarAuxiliar(){
       if (this.validarAuxiliar()){return;}
        let me = this;
        axios.post('/auxiliar/registrar',{
            'codcont': this.codcont,
            'nomaux': this.nomaux,
            'observ' : this.observ,
        }).then(function (response) {
            console.log(response.data);
            Swal.fire(response.data.message,"","info");
            me.cerrarModal();
            me.listarAuxiliar(1,response.data.codcont);
        }).catch(function (error) {
            console.log(error);
        });
      },
      validarAuxiliar(){
        let me=this;
        me.errorAuxiliar=0;
        me.errorMostrarMsjAuxiliar =[];
        
        if (me.nomaux==0) me.errorMostrarMsjAuxiliar.push("Ingrese un Nombre de Auxiliar");

        if (me.errorMostrarMsjAuxiliar.length) me.errorAuxiliar = 1;

        return me.errorAuxiliar;
      },
  },
  mounted() {
    this.listarUnidad ();
  }
}
</script>