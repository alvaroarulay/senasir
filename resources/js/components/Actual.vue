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
      
        <div class="row">
            <div class="col-md-12">
              <div class="tile" >
              
                <div class="tile-title row">
                    <div class="col-md-10">
                        <h3 class="mb-3 line-head">Activos Fijos</h3>
                    </div>
                    <div class="col-md-2">
                        <p class="bs-component d-grid">
                        <button type="button" @click="mostrarNuevo()" class="btn btn-primary btn-block"><i class="bi bi-plus-square"></i>&nbsp;Nuevo</button>
                        </p>
                    </div>
                </div>
                <template v-if="listado==0">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="codigo">Código</option>
                                    <option value="codigosec">Código Secundario</option>
                                    <option value="descripcion" selected>Descripción</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarbusqueda(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarbusqueda(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                        </div>
                    </div>
                    <div class="tile-body table-responsive">
                    <table class="table table-hover table-bordered table-sm" id="sampleTable">
                        <thead class="thead-light">
                        <tr>
                            <th>&nbsp;ACCIONES&nbsp;</th>
                            <th>STICKER</th>
                            <th>CÓDIGO</th>
                            <th>GRUPO CONTABLE</th>
                            <th>AUXLIAR</th>
                            <th>VIDA ÚTIL</th>
                            <th>OFICINA</th>
                            <th>RESPONSABLE</th>
                            <th>DESCRIPCIÓN</th>
                            <th>ESTADO</th>
                            <th>ASIGNACIÓN</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                <td>
                                    <button type="button" @click="mostrarEditar(articulo.id)" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></button> 
                                    <button type="button" @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
</td>
                                <td><button type="button" @click="sticker(articulo.id)" class="btn btn-danger btn-sm"><i class="bi bi-file-pdf"></i></button>
</td>
                                <td v-text="articulo.codigo"></td>
                                <td v-text="articulo.nombre"></td>
                                <td v-text="articulo.nomaux"></td>
                                <td v-text="articulo.vidautil"></td>
                                <td v-text="articulo.nomofic"></td>
                                <td v-text="articulo.nomresp"></td>
                                <td v-text="articulo.descripcion"></td>
                                <td>
                                    <div v-if="articulo.estado == 1">
                                        <span class="me-1 badge badge-pill bg-success">Bueno</span>
                                    </div>
                                    <div v-else-if="articulo.estado == 2">
                                        <span class="me-1 badge badge-pill bg-warning">Regular</span>
                                    </div>
                                    <div v-else>
                                        <span class="me-1 badge badge-pill bg-danger">Malo</span>
                                    </div>
                                </td>
                                <td>
                                    <div v-if="articulo.estadoasignacion == 1">
                                        <span class="me-1 badge badge-pill bg-success">Asignado</span>
                                    </div>
                                    <div v-else>
                                        <span class="me-1 badge badge-pill bg-warning">No Asignado</span>
                                    </div>
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
                </template>
                <template  v-else-if="listado==1" class="tile-body">
                    <div class="mb-3">
                        <Wizard
                            squared-tabs
                            card-background
                            navigable-tabs
                            scrollable-tabs
                            :nextButton="nextButtonOptions"
                            :backButton="backButtonOptions"
                            :custom-tabs="[
                            {
                                title: 'Paso 1',
                            },
                            {
                                title: 'Paso 2',
                            },
                            {
                                title: 'Paso 3',
                            },
                            {
                                title: 'Paso 4',
                            },
                            {
                                title: 'Paso 5',
                            },
                            ]"
                            :beforeChange="onTabBeforeChange"
                            @change="onChangeCurrentTab"
                            @complete:wizard="wizardCompleted"
                        >
                            <div v-if="currentTabIndex === 0">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Dependencias</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label">Grupo Contable:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select" v-model="id_contable" @change="onChangeCodigo($event)">
                                                    <option value="0">Seleccione..</option>
                                                    <option v-for="gcont in arrayContables" :value="gcont.id" v-text="gcont.nombre"></option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Oficina:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select" v-model="id_oficina" @change="onChangeOficina($event)">
                                                    <option value="0" selected> Seleccione...</option>
                                                    <option v-for="oficina in arrayOficina" :value="oficina.id" v-text="oficina.nomofic"></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label">Auxiliar:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select" v-model="id_auxiliar" @change="onChangeAuxiliar($event)">
                                                    <option value="0" selected> Seleccione...</option>
                                                    <option v-for="auxiliar in arrayAuxiliar" :value="auxiliar.id" v-text="auxiliar.nomaux"></option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Responsable:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select" v-model="id_responsable" @change="onChangeResponsable($event)">
                                                    <option value="0" selected> Seleccione...</option>
                                                    <option v-for="responsable in arrayResponsable" :value="responsable.id" v-text="responsable.nomresp"></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="currentTabIndex === 1">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Identificación</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label">Código:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="" id="" class="form-control" v-model="codigo_nuevo">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Código Secundario:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="" id="" class="form-control" v-model="codigo_sec">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label">Código ARPRO:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="" id="" class="form-control" v-model="codigo_arpro">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Fecha de Incorporación:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control" v-model="fecha_incorporacion">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="currentTabIndex === 2">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Detalles</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label">Estado:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="" id="" class="form-select" v-model="estado_nuevo">
                                                    <option value="0">Seleccione...</option>
                                                    <option value="1">Bueno</option>
                                                    <option value="2">Regular</option>
                                                    <option value="3">Malo</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Costo Incial:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="" id="" class="form-control" v-model="costo_inicial">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label">Descripción:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <textarea class="form-control" rows="3" v-model="descripcion_inicial"></textarea>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Observaciones:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <textarea class="form-control" rows="3" v-model="observ_inicial"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="currentTabIndex === 3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Financiamiento</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label">Vida Útil:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="" id="" class="form-control" v-model="vida_util">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Id Bien:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="" id="" class="form-control" v-model="id_bien">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label">Organismo Financiador:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="" id="" class="form-select" v-model="id_organismo">
                                                    <option value="0">Seleccione...</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Número de Convenio:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" v-model="nro_convenio">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="currentTabIndex === 4">
                                <div class="mb-3">
                                    <input class="form-control"  type="file" @change="uploadImage" accept="image/*">
                                    </div>
                                    <div class="row">
                                    <div v-for="image in selectedImages" :key="image.id" class="thumbnails float-left mr-1 col-sm-12 col-md-3">
                                            <img :src="image.url" alt="Miniatura" class="img-responsive" style="width: 100px; height: auto;">
                                    </div>
                                </div>
                            </div>
                        </Wizard>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <button class="btn btn-danger btn-block" @click="CancelarNuevo()">Cancelar</button>
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
                        <button type="button" class="close btn btn-danger" @click="cerrarModal()" aria-label="Close" >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row mb-3">
                                <label class="col-md-3 form-control-label" for="text-input">Grupo Contable</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="codcont" @change="onChange($event)">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="gcont in arrayContables" :key="gcont.codcont" :value="gcont.codcont" v-text="gcont.nombre"></option>
                                    </select>                                        
                                </div>
                            </div>
            
                            <div class="form-group row mb-3">
                                <label class="col-md-3 form-control-label" for="text-input">Auxiliar</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="codaux">
                                        <option v-for="aux in arrayAuxiliares" :key="aux.codaux" :value="aux.codaux" v-text="aux.nomaux"></option>
                                    </select>                                        
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-3 form-control-label" for="text-input">Descripción: </label>
                                <div class="col-md-9">
                                    <textarea class="form-control"  v-model="descripcion" ></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-3 form-control-label" for="text-input">Observaciones: </label>
                                <div class="col-md-9">
                                    <textarea class="form-control"  v-model="observaciones" ></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-3 form-control-label" for="text-input">Estado: </label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="codestado" @change="onChangeCodEstado($event)">
                                        <option value='1'>BUENO</option>
                                        <option value='2'>REGULAR</option>
                                        <option value='3'>MALO</option>
                                    </select>                                        
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-3 form-control-label" for="text-input">Código Secundario: </label>
                                <div class="col-md-9">
                                    <input type="text"  class="form-control" placeholder="" v-model="codigosec">                                        
                                </div>
                            </div>
                            <div v-show="errorArticulo" class="form-group row div-error mb-3">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <input class="form-control"  type="file" @change="uploadImage" accept="image/*">
                                </div>
                                <div class="row">
                                <div v-for="image in selectedImages" :key="image.id" class="thumbnails float-left mr-1 col-sm-12 col-md-3">
                                        <img :src="image.url" alt="Miniatura" class="img-responsive" style="width: 100px; height: auto;">
                                </div>
                                    <button class="btn btn-primary" @click="subirImagenes(id_actual)">Subir Imagenes</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
                <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalver}" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: scroll;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Detalle</h4>
                        <button type="button" class="close btn btn-danger" @click="cerrarModalImage()" aria-label="Close" >
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container" >
    <div class="row">
        <div class="col-md-6">
            <div class="bs-component">
                    <div class="card">
                        <h4 class="card-header">CODIGO ACTIVO FIJO: </h4>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="card-title">Grupo Contable:</h5>
                                    <h6 class="card-subtitle text-muted"></h6> 
                                </div>
                                <div class="col-md-6">
                                <h5 class="card-title">Auxiliar:</h5>
                                    <h6 class="card-subtitle text-muted"></h6> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="card-title">Oficina:</h5>
                                    <h6 class="card-subtitle text-muted"></h6> 
                                </div>
                                <div class="col-md-6">
                                <h5 class="card-title">Responsable:</h5>
                                    <h6 class="card-subtitle text-muted"></h6> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="card-title">Costo:</h5>
                                    <h6 class="card-subtitle text-muted"><b>Bs.- </b></h6> 
                                </div>
                                <div class="col-md-6">
                                <h5 class="card-title">Fecha de incorporación:</h5>
                                    <h6 class="card-subtitle text-muted"></h6> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="card-title">Vida Útil:</h5>
                                    <h6 class="card-subtitle text-muted"> año(s)</h6> 
                                </div>
                                <div class="col-md-6">
                                <h5 class="card-title">Estado:</h5>
                                    <h6 class="card-subtitle text-muted">Malo</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h5 class="card-title">Detalle:</h5>
                                <h6 class="card-subtitle text-muted"></h6>
                            </div>
                        </div>
                        <div class="card-footer text-muted">Ultima Actualización: </div>
                    </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div v-for="image in imagenes" :key="image.id" class="col">
                        <div class="card">
                            <img :src="getImageUrl(image)" :alt="image.nombre"  class="img-thumbnail img-fluid" />
                        </div>
                    </div>
            </div>
          
        </div>
    </div>
</div>               
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModalImage()">Cerrar</button>
                    </div>
                </div>
            </div>
                <!-- /.modal-content -->
        </div>
                    <!-- /.modal-dialog -->
    </main>
</template>
    
    <script>
        import axios from 'axios';
        import 'form-wizard-vue3/dist/form-wizard-vue3.css'
        import Wizard from 'form-wizard-vue3'

        export default {
            data (){
                return {
                    listado:0,
                    currentTabIndex: 0,
                    
                    //nuevo activo
                    codigo_nuevo:'',
                    codigo_sec:'',
                    codigo_arpro:'',
                    fecha_incorporacion: '',
                    descripcion_inicial:'',
                    estado_nuevo:0,
                    costo_inicial:0,
                    descripcion_inicial:'',
                    observ_inicial:'',
                    vida_util:0,
                    id_bien:0,
                    id_organismo:0,
                    nro_convenio:'',
                    //oficina
                    id_oficina : 0,
                    arrayOficina:[],
                    //responsables
                    id_responsable : 0,
                    arrayResponsable : [],
                    //grupocontable
                    id_contable : 0,
                    arrayContables : [],
                    //auxiliares
                    id_auxiliar : 0,
                    arrayAuxiliar : [],
                    //actuales
                    id_actual:0,
                    codigo : '',
                    codcont:0,
                    codaux:0,
                    descripcion : '',  
                    observaciones : '',      
                    codestado : 0,
                    estadoasignacion :0,
                    codigosec:0,
                    articulo_id: 0,
                    popUp: false,
                    idArticulo:0,

                    idunidad:1,
                    unidad:'',
                    arrayUnidad:[],
                    selectUnidad:0,

                    arrayContables : [],
                    arrayAuxiliares : [],
                    selectedImages: [],
                    imagenes: [],

                    nombre : '',
                    
                    arrayArticulo : [],
                    modal : 0,
                    modalver : 0,
                    tituloModal : '',
                    tipoAccion : 0,
                    errorArticulo : 0,
                    errorMostrarMsjArticulo : [],
                    pagination : {
                        'total' : 0,
                        'current_page' : 0,
                        'per_page' : 0,
                        'last_page' : 0,
                        'from' : 0,
                        'to' : 0,
                    },
                    offset : 3,
                    criterio : 'descripcion',
                    buscar : '',
                    mostrandoEditar: false,
                }
            },
            components: {   
                Wizard,
        },
            computed:{
                nextButtonOptions() {
                    return this.id_auxiliar == 0 || this.id_responsable == 0
                    ? {
                        text: 'Siguiente',
                        icon: 'arrow-right',
                        hideIcon: true, // default false but selected for sample
                        hideText: false, // default false but selected for sample
                        disabled: true,
                    }
                    : { 
                            text: 'Siguiente',
                            icon: 'arrow-right',
                            hideText: false,
                            hideIcon: false,
                            disabled: false,
                            disabled: false 
                    };
                   
                },
                backButtonOptions() {
                
                return this.currentTabIndex === 0
                    ? {
                        
                        text: 'Anterior',
                        icon: 'arrow-left',
                        hideIcon: true, // default false but selected for sample
                        hideText: false, // default false but selected for sample
                        disabled: true,
                    }
                    : { 
                        text: 'Anterior',
                        icon: 'arrow-left',
                        hideText: false,
                        hideIcon: false,
                        disabled: false,
                        disabled: false 
                    };
                },
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
            methods : {
                sticker(id){
                    window.open('http://senasirprueba.test/actuales/imprimir/' + id +  '','_blank');
                },
                CancelarNuevo(){
                    this.listado=0;
                    this.currentTabIndex=0;
                    this.listarArticulo(1,this.buscar,this.criterio);
                },
                onChangeCurrentTab(index, oldIndex) {
                    console.log(index, oldIndex);
                    this.currentTabIndex = index;
                    },
                onTabBeforeChange() {
                    if (this.currentTabIndex === 0) {
                        console.log('First Tab');
                    }
                },
                wizardCompleted() {
                    //if (this.validarArticulo()){return;}
                    let me = this;
                    axios.post('/actuales/registrar',{
                        'codigo_nuevo':me.codigo_nuevo,
                        'codigo_sec':me.codigo_sec,
                        'codigo_arpro':me.codigo_arpro,
                        'fecha_incorporacion':me.fecha_incorporacion,
                        'descripcion_inicial':me.descripcion_inicial,
                        'estado_nuevo':me.estado_nuevo,
                        'costo_inicial':me.costo_inicial,
                        'observ_inicial':me.observ_inicial,
                        'vida_util':me.vida_util,
                        'id_bien':me.id_bien,
                        'id_organismo':me.id_organismo,
                        'nro_convenio':me.nro_convenio,
                        'id_aux':me.id_auxiliar,
                        'id_responsable':me.id_responsable
                    }).then((response)=>{
                        me.subirImagenes(response.data.id);
                    }).catch((error)=>{
                        Swal.fire("Ocurrio un error ", "", "error");
                        console.log(error.response.data);
                        
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
                onChangeUnidad(event){
                    this.id_oficina = 0;
                    this.id_auxiliar = 0;
                    this.id_contable = 0;
                    this.id_responsable = 0;
                    this.idunidad=(event.target.value);
                    const res = this.arrayUnidad.find((unidad) => unidad.id == this.idunidad);
                    this.listarOficina(res.id);
                    this.listarContables(res.id);
                },
                listarContables (id){
                    let me=this;
                    var url= '/contable?id='+ id;
                    axios.get(url).then( (response) =>{
                        var respuesta= response.data;
                        me.arrayContables = respuesta.codigos;
                    })
                    .catch( (error)=> {
                        console.log(error);
                    });
                },
                onChangeCodigo(event) {
                    this.id_contable=(event.target.value);
                    this.listarAuxiliar(this.id_contable);
                },
                listarAuxiliar (id){
                    let me=this;
                    var url= '/auxiliar/listar?id='+ id;
                    axios.get(url).then( (response) =>{
                        var respuesta= response.data;
                        me.arrayAuxiliar = respuesta.auxiliares;
                    })
                    .catch( (error)=> {
                        console.log(error);
                    });
                },
                onChangeAuxiliar(event){
                    this.id_auxiliar=(event.target.value);

                },
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
                listarResponsable (id){
                    let me=this;
                    var url= '/responsable/listarep?id='+ id;
                    axios.get(url).then( (response) =>{
                        var respuesta= response.data;
                        me.arrayResponsable = respuesta.responsables;
                        console.log(respuesta);
                    })
                    .catch( (error)=> {
                        console.log(error);
                    });
                },
                onChangeResponsable(event){
                    this.id_responsable=(event.target.value);
                },
                onChangeOficina(event){
                    this.id_responsable=0;
                    this.id_oficina=(event.target.value);
                    const res = this.arrayOficina.find((oficina) => oficina.id == this.id_oficina);
                    this.listarResponsable(res.id);
                },
                listarbusqueda(page,buscar,criterio){
                    if (this.buscar=='') {
                        Swal.fire('Escriba un texto','','error');
                    };
                    this.listarArticulo (page,buscar,criterio);
                },
                listarArticulo (page,buscar,criterio){
                    let me=this;
                    
                    var url= '/actuales?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        me.arrayArticulo = respuesta.actuales.data;
                        me.pagination= respuesta.pagination;
                       
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                listarGrupoContable (){
                    let me=this;
                    var url= '/actuales';
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        me.arrayContables = respuesta.grupocontable;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                listarAuxiliar2 (id){
                    var url= '/auxiliar/' + id;
                    axios.get(url).then((response)=> {

                        this.arrayAuxiliares= response.data.auxiliares;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                cambiarPagina(page,buscar,criterio){
                    let me = this;
                    //Actualiza la página actual
                    me.pagination.current_page = page;
                    //Envia la petición para visualizar la data de esa página
                    me.listarArticulo(page,buscar,criterio);
                },
                abrirModal(modelo, accion, data = []){
                    switch(modelo){
                    case "articulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Nuevo Artículo: ';
                                this.idArticulo =0;
                                this.codigo = '';
                                this.codcont= '';
                                this.codaux = '';
                                this.descripcion ='';
                                this.observaciones = '';
                                this.codestado ='';
                                this.codigosec='';
                                this.tipoAccion=1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.listarAuxiliar(data['codcont']);
                                this.modal=1;
                                this.tituloModal='Actualizar Artículo: '+ data['codigo'];
                                this.idArticulo =data['id'];
                                this.codigo = data['codigo'];
                                this.codcont= data['codcont'];
                                this.codaux = data['codaux'];
                                this.descripcion = data['descripcion'];
                                this.observaciones = data['observ'];
                                this.codestado =data['codestado'];
                                this.codigosec=data['codigosec'];
                                this.tipoAccion=2;
                                break;
                            }
                        }
                    }
                    
                    }
                },
                onChange(event) {
                    this.listarAuxiliar(event.target.value);
                },
                onChangeCodEstado(event) {
                    this.codestado = (event.target.value);
                },
                uploadImage(event) {
                    const files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        this.previewImage(files[i]);
                    }
                    },
                previewImage(file) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        this.selectedImages.push({
                        id: this.selectedImages.length + 1, // Puedes usar un identificador único
                        url: e.target.result,
                        file: file,
                        });
                    };

                    reader.readAsDataURL(file);
                },
                subirImagenes(id) {
                    this.selectedImages.forEach((file) => {
                    const formData = new FormData();
                    
                    formData.append('codactual', id);
                    formData.append('image', file.file);
                    axios
                        .post('/image/crear', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                        })
                        .then((response) => {
                        Swal.fire({
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                        });
                        this.CancelarNuevo();
                        this.selectedImages = [];
                        })
                        .catch((error) => {
                            Swal.fire('Error al subir la imagen '+error.response.data,'', 'error');
                        });
                    });
                    
                },
                
                actualizarArticulo(){
                    if (this.validarArticulo()){
                    return;
                    }
                    let me = this;
                axios.put('/actual/actualizar',{
                    'id': this.idArticulo,
                    'codigo':this.codigo,
                    'codcont': this.codcont,
                    'codaux': this.codaux,
                    'descripcion' : this.descripcion,
                    'observacion' : this.observaciones,
                    'estado' : this.codestado,
                    'codsec' : this.codigosec
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarArticulo(1,'','descripcion');
                    Swal.fire(response.data.message, "", "success");
                }).catch(function (error) {
                    Swal.fire(error.response.data, "", "error");
                }); 
                },
                cerrarModal(){
                    this.modal=0;
                    this.codigo = '';
                    this.descripcion = '';
                    this.codcont=0;
                    this.codaux=0;    
                    this.codestado =0;
                    this.estadoasignacion =0;
                    this.codigosec=0;
                    this.errorArticulo=0;
                    this.selectedImages= [];
                },
                cerrarModalImage(){
                    this.modalver=0;
                    this.imagenes= [];
                },
                validarArticulo(){
                    this.errorArticulo=0;
                    this.errorMostrarMsjArticulo =[];
                    if (this.descripcion.length >= 151) this.errorMostrarMsjArticulo.push("La descripción no puede ser mas de 150 caracteres.");

                    if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

                    return this.errorArticulo;
                },
                mostrarEditar(id){
                    let me = this;
                    me.id_actual=id;
                    axios.get('/image/ver/' + id).then((response) =>{
                        if(response.data.imagenes.length > 0){
                            me.modalver=1;
                        }else{
                            Swal.fire("No hay Imagenes 😔","","info");
                        }
                        me.imagenes = response.data.imagenes;
                    }).catch((error)=> {
                    Swal.fire("Existe un Problema ", "", "error");
                    }); 
                },
                getImageUrl(image) {
                    return `/images/${image.nombre}`;
                },
                mostrarNuevo(){
                    if(this.selectUnidad==0){
                        Swal.fire("Seleccione una Unidad","","info")
                    }else{
                    this.listado=1;
                    }
                }
            },
            mounted() {
                this.listarUnidad();
                this.listarArticulo(1,this.buscar,this.criterio);
                //this.listarGrupoContable();
            }
        }
    </script>
    <style> 
        .mostrar{
            display: list-item !important;
            opacity: 1 !important;
            position: absolute !important;
            background-color: #3c29297a !important;
        }
        .div-error{
            display: flex;
            justify-content: center;
        }
        .text-error{
            color: red !important;
            font-weight: bold;
        }
        .thumbnails {
        display: flex;
        flex-wrap: wrap;
        }

        .thumbnail {
        margin: 10px;
        }

    </style>