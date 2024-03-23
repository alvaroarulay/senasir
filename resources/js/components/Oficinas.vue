<template>
      <main class="app-content">
        <div class="app-title">
            <div class="col-md-8">
               <h1><i class="bi bi-collection"></i> Unidad: <p v-text="unidad"></p></h1> 
            </div>
            <div class="col-md-4">
                <select class="form-select" v-model="selectUnidad" @change="onChangeUnidad($event)">
                    <option value="0" selected> Seleccione...</option>
                    <option v-for="unidad in arrayUnidad" :value="unidad.id" v-text="unidad.descrip"></option>
                </select>
            </div>
        </div>
        <div class="tile">
            <h3 class="tile-title">Oficina</h3>
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label class="form-label col-md-3">Oficina</label>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input class="form-control" type="text" v-model="id_oficina" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <select class="form-select" v-model="codofic" @change="onChangeOficina($event)">
                            <option value="0" selected> Seleccione...</option>
                            <option v-for="oficina in arrayOficina" :value="oficina.id" v-text="oficina.nomofic"></option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input class="form-control" v-if="estado==1" type="text"  value="ACTIVO" disabled>
                        <input class="form-control" v-if="estado==0" type="text"  value="INACTIVO" disabled>                
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label class="form-label col-md-3">Observaciones</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control" rows="3" v-model="observaciones" disabled></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"></div>
                    <div class="col-md-2"> <p class="bs-component d-grid">
                          <button class="btn btn-primary btn-block" type="button" @click="abrirModal('oficina','registrar')"><i class="bi bi-plus-square"></i> Nuevo</button>
                       </p>
                    </div>
                    <div class="col-md-2">
                        <p class="bs-component d-grid">
                            <button class="btn btn-warning btn-block" type="button" @click="abrirModal('oficina','actualizar',this.id_oficina)"><i class="bi bi-pencil-square"></i>Modificar</button>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <p class="bs-component d-grid">
                            <button class="btn btn-info btn-block" type="button" v-if="this.estado==0" @click="ActivarOficina(this.id_oficina)"><i class="bi bi-check2-square"></i>Activar</button>
                            <button class="btn btn-danger btn-block" type="button" v-if="this.estado==1" @click="InactivarOficina(this.id_oficina)"><i class="bi bi-x-square"></i>Inactivar</button>
                        </p>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-title row">
                <div class="col-md-10">
                    <h3 class="mb-3 line-head">Responsables</h3>
                </div>
                <div class="col-md-2">
                    <p class="bs-component d-grid">
                    <button type="button" @click="mostrarNuevo()" v-if="accion==1" class="btn btn-primary btn-block"><i class="bi bi-plus-square"></i>&nbsp;Nuevo</button>
                    </p>
                </div>
            </div>
            <template v-if="listado==1">
                <div class="tile-body table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Carnet</th>
                                <th>Expedido</th>
                                <th>Cargo</th>
                                <th>Estado</th>
                                <th>Contrato termina en:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <button type="button" @click="abrirListado(persona)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar">
                                          <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </td>
                                    <td v-text="persona.nomresp"></td>
                                    <td v-text="persona.ci"></td>
                                    <td v-text="persona.expedicion"></td>
                                    <td v-text="persona.cargo"></td>
                                    <td>
                                        <div v-if="persona.estado==1">
                                            <span class="me-1 badge badge-pill bg-success">Activo</span>
                                        </div>
                                        <div v-else-if="persona.estado==0">
                                            <span class="me-1 badge badge-pill bg-danger">Inactivo</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <div v-if="mostrarFecha(persona.fin)>31">
                                            <span class="me-1 badge badge-pill bg-success">{{ mostrarFecha(persona.fin) + " Dia(s)" }}</span>
                                        </div>
                                        <div v-else-if="mostrarFecha(persona.fin)<30 && mostrarFecha(persona.fin)>10 ">
                                            <span class="me-1 badge badge-pill bg-warning">{{ mostrarFecha(persona.fin) + " Dia(s)" }}</span>
                                        </div>
                                        <div v-else-if="mostrarFecha(persona.fin)<10 && mostrarFecha(persona.fin)>1">
                                            <span class="me-1 badge badge-pill bg-danger">{{ mostrarFecha(persona.fin) + " Dia(s)" }}</span>
                                        </div>
                                        <div v-else-if="mostrarFecha(persona.fin)<=0">
                                            <span class="me-1 badge badge-pill bg-danger">{{"finalizado" }}</span>
                                        </div>
                                    </td>
                                </tr>                      
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </template>
            <template v-else-if="listado==2">
                <div class="tile-body">

                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label class="form-label">Nombre de Responsable:</label>
                            <input class="form-control" type="text" v-model="nomresp">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombre de Usuario:</label>
                            <input class="form-control" type="text" v-model="user">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label class="form-label">E-mail:</label>
                            <input class="form-control" type="e-mail" v-model="email">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cargo:</label>
                            <input class="form-control" type="text" v-model="cargo">
                        </div>
                    </div>


                    <div class="mb-3 row">
                        <div class="col-md-4">
                            <label class="form-label">Observaciones:</label>
                            <textarea class="form-control" rows="3" v-model="observ"></textarea> 
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Carnet de Identidad:</label>
                            <input class="form-control" type="text" v-model="ci">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Expedido en:</label>
                            <div class="input-group">
                                <select v-model="expedido" class="form-select">
                                <option value='CHQ'>CHUQUISACA</option>
                                <option value='LPZ'>LA PAZ</option>
                                <option value='CBBA'>COCHABAMBA</option>
                                <option value='ORU'>ORURO</option>
                                <option value='PTS'>POTOSI</option>
                                <option value='TAR'>TARIJA</option>
                                <option value='SCZ'>SANTA CRUZ</option>
                                <option value='BEN'>BENI</option>
                                <option value='PAN'>PANDO</option>
                                <option value='QR'>QR</option>
                                </select>   
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-3">
                            <label class="form-label">Role de usuario:</label>
                            <div class="input-group">
                                <select v-model="idrol" class="form-select">
                                <option value='1'>ADMINISTRADOR</option>
                                <option value='2'>OPERADOR</option>
                                <option value='3'>USUARIO</option>
                                </select>   
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Estado:</label>
                            <div class="input-group">
                                <select v-model="estadoresp" class="form-select">
                                    <option value='0'>INACTIVO</option>
                                    <option value='1' selected>ACTIVO</option>
                                </select>   
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Inicio del Contrato:</label>
                            <input type="date" class="form-control" v-model="inicio">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fin del Contrato:</label>
                            <input type="date" class="form-control" v-model="fin">
                        </div>
                    </div>
                    <div v-show="errorResponsable" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjResponsable" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                </div>
                <div class="tile-footer">
                    <div class="form-group row">
                        <div class="col-md-2 mb-3">
                            <p class="bs-component d-grid">
                            <button type="button" @click="ocultarDetalle()" class="btn btn-danger btn-block"><i class="bi bi-x-square"></i>Cerrar</button>
                            </p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <p class="bs-component d-grid">
                            <button type="button" class="btn btn-success btn-block" v-if="accion==1" @click="registrarResponsable()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2z"/>
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                        </svg>Guardar</button>
                        <button type="button" class="btn btn-warning btn-block" v-if="accion==2" @click="actualizarResponsable()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2z"/>
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                        </svg>Actualizar</button>
                        </p>
                        </div>
                    </div>
                </div>
            </template>
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
                            <label class="col-md-2" for="text-input">Nombre Oficina</label>
                            <div class="col-md-10">
                                <input type="text" v-model="nomofic" class="form-control">                                        
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label class="col-md-4" for="text-input">Observaciones</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" rows="3" v-model="observaciones"></textarea>                                      
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row mb-3">
                            <label class="col-md-3" for="text-input" >Estado:</label>
                            <div class="col-md-9">
                                <select class="form-select" v-model="estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>                                    
                            </div>
                            </div>
                            </div>
                        </div>
                        <div v-show="errorOficina" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjOficina" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="cerrarModal()"><i class="bi bi-x-square"></i>Cerrar</button>
                    <button type="button" class="btn btn-warning" v-if="tipoAccion==2" @click="actualizarOficina()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2z"/>
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                        </svg>Actualizar
                    </button>
                    <button type="button" class="btn btn-success" v-if="tipoAccion==1" @click="registrarOficina()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
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
      user:'',
      email:'',
      idrol:1,
      listado:1,
      accion:1,
      codofic:0,
      id_oficina:0,
      selectUnidad:0,
      observaciones:'',
      nomofic:'',
      estado:1,
      idunidad:1,
      unidad:'',
      nomresp:'',
      cargo:'',
      id_responsable:0,
      observ:'',
      ci:0,
      expedido:'LPZ',
      estadoresp:1,
      inicio:'',
      fin:'',
      arrayOficina : [],
      arrayUnidad:[],
      arrayPersona : [],
      modal : 0,
      tituloModal:'',
      errorOficina : 0,
      errorMostrarMsjOficina : [],
      errorResponsable : 0,
      errorMostrarMsjResponsable : [],
      tipoAccion:0,
      pagination : {
          'total' : 0,
          'current_page' : 0,
          'per_page' : 0,
          'last_page' : 0,
          'from' : 0,
          'to' : 0,
      },
      offset : 3,
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
    listarOficina (unidad){
        let me=this;
        var url= '/oficinas?unidad=' + unidad;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayOficina = respuesta.oficinas;
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
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    listarPersona (page,id){
        let me=this;
        var url= '/responsable/listar?page=' + page + '&id='+ id;
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayPersona = respuesta.responsables.data;
            me.pagination= respuesta.pagination;
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    mostrarNuevo(){
        let me=this;
        if (me.id_oficina==0 || me.estado==0)
        {
            Swal.fire('Seleccione una Oficina u Oficina Inactiva','','error');
            me.listado=1;
        }
        else{
            me.listado=2;
        }
    },
    onChangeUnidad(event){
        this.arrayOficina = [];
        this.arrayPersona = [];
        this.pagination = [];
        this.codofic = 0;
        this.id_oficina = 0;
        this.observaciones = '';
        this.estado = 0;
        this.idunidad=(event.target.value);
        const res = this.arrayUnidad.find((unidad) => unidad.id == this.idunidad);
        this.unidad = res.descrip;
        this.listarOficina(res.id);
    },
    onChangeOficina(event){
        this.id_oficina=(event.target.value);
        const res = this.arrayOficina.find((oficina) => oficina.id == this.id_oficina);
        this.observaciones = res.observ;
        this.estado = res.estado;
        this.listarPersona(1,res.id);
    },
    abrirModal(modelo, accion, id){
        switch(modelo){
            case "oficina":
            {
                switch(accion){
                    case 'registrar':
                    {
                        if(this.selectUnidad==0){Swal.fire("Seleccione una Unidad." , "", "error"); this.modal=0; break}
                        this.modal = 1;
                        this.tituloModal = 'Registrar Oficina';
                        this.id_oficina=0;
                        this.nomofic='';
                        this.observaciones='';
                        this.estado=0;
                        this.tipoAccion = 1;
                        break;
                    }
                    case 'actualizar':
                    {
                        if(this.id_oficina==0){Swal.fire("Seleccione una Oficina." , "", "error"); this.modal=0; break}
                        const res = this.arrayOficina.find((oficina) => oficina.id == id);
                        this.modal=1;
                        this.tituloModal = 'Actualizar Oficina';
                        this.id=res.id;
                        this.nomofic=res.nomofic;
                        this.observaciones=res.observ;
                        this.tipoAccion=2;
                        break;
                    }
                }
            }
        }
     
    },
    cerrarModal(){
      this.modal=0;
      this.nomofic='';
      this.observaciones='';
      this.estado=1;
      this.errorOficina=[];
      this.errorMostrarMsjOficina=[];
    },
    cambiarPagina(page){
        let me = this;
        me.pagination.current_page = page;
        me.listarOficina(page);
    },
    actualizarOficina(){
        let me = this;
        axios.put('/oficinas/actualizar',{
            'id': me.id_oficina,
            'nomofic': me.nomofic,
            'observ' : me.observaciones,
            'estado' : me.estado,
            'unidad' : me.idunidad
        }).then( (response) =>{
            me.cerrarModal();
            me.listarOficina(response.data.unidad);
            Swal.fire(response.data.message, "", "success");
        }).catch(function (error) {
            Swal.fire(error , "", "error");
        });
    },
    registrarOficina(){
        let me = this;
        if (me.validarOficina()){return;}
        axios.post('/oficinas/registrar',{
            'nomofic': me.nomofic,
            'observ' : me.observaciones,
            'estado' : me.estado,
            'unidad' : me.idunidad
        }).then( (response) => {
            me.cerrarModal();
            me.listarOficina(response.data.idunidad);
            me.listado = 1;
            Swal.fire(response.data.message, "", "success");
        }).catch( (error) => {
            Swal.fire(error , "", "error");
        });
    },
    validarOficina(){
        let me=this;
        me.errorOficina=0;
        me.errorMostrarMsjOficina =[];
        if (me.nomofic=='') me.errorMostrarMsjOficina.push("Ingrese un Nombre de Oficina");
        if (me.errorMostrarMsjOficina.length) me.errorOficina = 1;
        return me.errorOficina;
    },
    InactivarOficina(id){
        Swal.fire({
            title: "Esta Seguro?",
            text: "Se desactivará esta Oficina!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: 'Cancelar!',
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Desactivar!"
            }).then((result) => {
            if (result.isConfirmed) {
                let me = this;
                axios.put('/oficinas/desactivar',{
                    'id': id
                }).then((response) =>{
                    Swal.fire({
                        title: "Desctivado!",
                        text: response.data.message,
                        icon: "success"
                        });
                    me.estado=0;
            }).catch((error) =>{
            console.log(error);
            });
            }
            });
    },
    ActivarOficina (id){
    Swal.fire({
        title: "Esta Seguro?",
        text: "Se activará esta Oficina!",
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: 'Cancelar!',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Activar!"
        }).then((result) => {
        if (result.isConfirmed) {
            let me = this;
        axios.put('/oficinas/activar',{
        'id': id
        }).then((response) =>{
        me.listarOficina(response.data.id);
            Swal.fire({
            title: "Activado!",
            text: response.data.message,
            icon: "success"
            });
            me.estado=1;
        }).catch((error) =>{
        console.log(error);
        });
        }
        });
    },
    ocultarDetalle(){
        this.listado=1;
        this.accion=1;
        this.nomresp='';
        this.cargo='';
        this.observ='';
        this.ci=0;
        this.expedido='LPZ';
        this.estadoresp=1;
        this.user='';
        this.email='';
        this.idrol=1;
        this.inicio='';
        this.fin='';
        this.errorMostrarMsjResponsable=[];
        this.errorResponsable=[];
    },
    abrirListado(data=[]){
        let me = this;
        me.listado=2;
        me.accion=2;
        me.id_responsable=data['id'];
        me.nomresp=data['nomresp'];
        me.cargo=data['cargo'];
        me.ci=data['ci'];
        me.expedido=data['expedicion'];
        me.estadoresp=data['estado'];
        me.user=data['username'];
        me.email=data['email'];
        me.idrol=data['idrol'];
        me.inicio=new Date(data['inicio']).toISOString().slice(0, 10);
        me.fin=new Date(data['fin']).toISOString().slice(0, 10);
        me.observ=data['observ'];
        console.log(me.fin);
    },
    registrarResponsable(){
        let me = this;
        if (me.validarResponsable()){return;}
        axios.post('/responsable/registrar',{
            'codofic' : me.codofic,
            'nomresp' : me.nomresp,
            'cargo' : me.cargo,
            'observ' : me.observ,
            'ci' : me.ci,
            'expedido' : me.expedido,
            'estado' : me.estadoresp,
            'inicio' : me.inicio,
            'fin' : me.fin,
            'user' : me.user,
            'email' : me.email,
            'idrol' : me.idrol,
        }).then( (response) =>{
            me.ocultarDetalle();
            Swal.fire(response.data.message, "", "success");
            me.listarPersona (1,response.data.codofic);
        }).catch(function (error) {
            Swal.fire(error , "", "error");
        });
    },
    actualizarResponsable(){
        let me = this;
        //if (me.validarResponsable()){return;}
        axios.put('/responsable/actualizar',{
            'id':me.id_responsable,
            'codofic' : me.codofic,
            'nomresp' : me.nomresp,
            'cargo' : me.cargo,
            'observ' : me.observ,
            'ci' : me.ci,
            'expedido' : me.expedido,
            'estado' : me.estadoresp,
            'inicio' : me.inicio,
            'fin' : me.fin,
            'user' : me.user,
            'email' : me.email,
            'idrol' : me.idrol,
        }).then( (response) =>{
            me.ocultarDetalle();
            Swal.fire(response.data.message, "", "success");
            me.listarPersona (1,response.data.codofic);
        }).catch( (error) =>{
            Swal.fire(error , "", "error");
            console.log(error);
        });
    },
    validarResponsable(){
        let me=this;
        me.errorResponsable=0;
        me.errorMostrarMsjResponsable =[];
        let validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
        let validText = /^[ a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/;
        let validnumber = /^([0-9])*$/;
        let validauser = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/;

        if (me.nomresp == null || me.nomresp.length == 0 || !validText.test(me.nomresp)) me.errorMostrarMsjResponsable.push("Nombre de responsable incorrecto");
        if (me.cargo == null || me.cargo.length == 0 || !validText.test(me.cargo)) me.errorMostrarMsjResponsable.push("Cargo incorrecto");
        if (me.ci == null || me.ci.length == 0 || !validnumber.test(me.ci)) me.errorMostrarMsjResponsable.push("Carnet de Identidad incorrecto");
        if (me.user == null || me.user.length == 0 || !validauser.test(me.user)) me.errorMostrarMsjResponsable.push("Nombre de usuario incorrecto");
        if (me.email == null || me.email.length == 0 || !validEmail.test(me.email)){me.errorMostrarMsjResponsable.push("E-mail incorrecto")}
        
        if (me.inicio=='') me.errorMostrarMsjResponsable.push("Seleccione una fecha de inicio de contrato");
        if (me.fin=='') me.errorMostrarMsjResponsable.push("Seleccione una fecha de fin de contrato");
        
        if (me.errorMostrarMsjResponsable.length) me.errorResponsable = 1;
        return me.errorResponsable;
    },
    mostrarFecha(fecha) {
        
        const today = new Date();
        const final = new Date(fecha + " GMT-0400");
        let resta = final - today;
        
        var dias = Math.round(resta / (1000 * 60 * 60 * 24));

        return dias ; 

    }
    },
  mounted() {
   this.listarUnidad();
  }
}
</script>