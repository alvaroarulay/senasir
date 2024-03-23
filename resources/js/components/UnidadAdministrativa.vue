<template>
    <main class="app-content">
      <div class="app-title">
            <h1><i class="bi bi-person-fill"></i> Unidad Aministrativa</h1>
            <br>
            <button type="submit" @click="abrirModal('unidad','registrar')" class="btn btn-primary"><i class="bi bi-plus-square"></i> Nueva Unidad</button>
        </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body table-responsive">
                 <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Unidad</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="unidad in arrayUnidad" :key="unidad.id">
                            <td>
                                <button type="button" @click="abrirModal('unidad','actualizar',unidad)" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar">
                                  <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                            <td v-text="unidad.unidad"></td>
                            <td v-text="unidad.descrip"></td>
                            <td>
                                <div v-if="unidad.estado==1">
                                    <span class="me-1 badge badge-pill bg-success">Activo</span>
                                </div>
                                <div v-else-if="unidad.estado==0">
                                    <span class="me-1 badge badge-pill bg-danger">Inactivo</span>
                                </div>
                                
                            </td>
                        </tr>                                
                    </tbody>
                </table>
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
                                    <label class="col-md-3" for="text-input">Unidad</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="unidad" class="form-control">                                        
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-3" for="text-input">Descripcion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control">                                        
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-3" for="text-input">Estado</label>
                                    <div class="col-md-9">
                                      <select class="form-select" v-model="estado" @change="onChange($event)">
                                          <option value="1">Activo</option>
                                          <option value="0">Inactivo</option>
                                      </select>                            
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-3" for="text-input">Ciudad</label>
                                    <div class="col-md-9">
                                      <select class="form-select" v-model="departamento">
                                          <option value="La Paz">La Paz</option>
                                          <option value="Cochabamba">Cochabamba</option>
                                          <option value="Santa Cruz">Santa Cruz</option>
                                          <option value="Oruro">Oruro</option>
                                          <option value="Potosí">Potosí</option>
                                          <option value="Chuquisaca">Chuquisaca</option>
                                          <option value="Tarija">Tarija</option>
                                          <option value="Beni">Beni</option>
                                          <option value="Pando">Pando</option>
                                      </select>                            
                                    </div>
                                </div>
                                <div v-show="errorUnidad" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjUnidad" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="nuevaUnidad()" v-if="tipoAccion==1">Registrar</button>
                            <button type="button" class="btn btn-primary" @click="actualizarUnidad()" v-if="tipoAccion==2">Actualizar</button>
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
      tituloModal:'',
      tipoAccion:0,
      id:0,
      unidad:'',
      descripcion:'',
      estado:'',
      departamento:'La Paz',
      arrayUnidad:[],
      errorUnidad:0,
      errorMostrarMsjUnidad:[],
      modal:0,
    }
  },
  methods: {
    listarUnidad (){
        let me=this;
        var url= '/unidad';
        axios.get(url).then( (response) =>{
            var respuesta= response.data;
            me.arrayUnidad = respuesta.unidad;
        })
        .catch( (error)=> {
            console.log(error);
        });
    },
    onChange(event) {
        this.estado=(event.target.value);
    },
    abrirModal(modelo, accion, data = []){
        switch(modelo){
            case "unidad":{
                switch(accion){
                    case "registrar":{
                        this.modal=1;
                        this.tituloModal='Nueva Unidad Administrativa';
                        this.tipoAccion = 1;
                        this.id = 0;
                        this.unidad='';
                        this.descripcion='';
                        this.estado = 1;
                        this.departamento = 'La Paz';
                        break;
                    }
                    case "actualizar":{
                        this.modal=1;
                        this.tituloModal='Actualizar Unidad Administrativa';
                        this.tipoAccion = 2;
                        this.id = data['id'];
                        this.unidad=data['unidad'];
                        this.descripcion=data['descrip'];
                        this.estado = data['estado'];
                        this.departamento = data['ciudad'];
                        break;
                    }
                }
            }
        }
      
    },
    cerrarModal(){
      this.modal=0;
      this.id =0;
      this.nombre='';
      this.descripcion='';
      this.errorMostrarMsjUnidad=[];
      this.errorUnidad=[];
    },
    nuevaUnidad(){
        let me = this;
        if (me.validarUnidad()){return;};
          axios.post('/unidad/registrar',{
            'unidad':me.unidad,
            'descripcion':me.descripcion,
            'estado':me.estado,
            'departamento':me.departamento,
          }).then( (response)=> {
              me.cerrarModal();
              Swal.fire(response.data.message,"","info");
              me.listarUnidad();
          }).catch( (error)=> {
            Swal.fire('Hubo un Error',"","error");
              console.log(error);
          }); 
    },
    actualizarUnidad(){
          let me = this;
          if (me.validarUnidad()){return;};
          axios.put('/unidad/actualizar',{
            'id':me.id,
            'unidad':me.unidad,
            'descripcion':me.descripcion,
            'estado':me.estado,
            'departamento':me.departamento,
          }).then( (response)=> {
              me.cerrarModal();
              Swal.fire(response.data.message,"","info");
              me.listarUnidad();
          }).catch( (error)=> {
            Swal.error('Hubo un Error');
              console.log(error);
          }); 
      }, 
      validarUnidad(){
        let me=this;
        me.errorUnidad=0;
        me.errorMostrarMsjUnidad =[];
        
        if (me.unidad==0) me.errorMostrarMsjUnidad.push("Ingrese un Nombre de Unidad");
        if (me.descripcion==0) me.errorMostrarMsjUnidad.push("Ingrese una Descripción");
        if (me.errorMostrarMsjUnidad.length) me.errorUnidad = 1;

        return me.errorUnidad;
      },
  },
  mounted() {
    this.listarUnidad();
  }
}
</script>