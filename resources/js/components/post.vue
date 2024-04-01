<template>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-envelope-at"></i> Mis Mensajes</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item"><a href="#">Mensajes</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="d-grid"><a class="mb-2 btn btn-primary btn-block" href="" @click.prevent="redactar()">Redactar Mensaje</a></div>
          <div class="tile p-0">
            <h4 class="tile-title folder-head">Carpetas</h4>
            <div class="tile-body">
              <ul class="nav nav-pills flex-column mail-nav">
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-start" href="#" @click.prevent="cancel()">
                        <span><i class="bi bi-inbox me-1 fs-5"></i> Bandeja de Entrada</span>
                        <span class="badge bg-primary rounded-pill" v-text="noleidas.length"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-start" href="#" @click.prevent="enviados()">
                        <span><i class="bi bi-envelope me-1 fs-5"></i> Bandeja de Salida</span>
                        <span class="badge bg-primary rounded-pill" v-text="arrayMensajes.length"></span>
                    </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="tile">
            <div class="mailbox-controls">
              <div class="form-check">
                <label>
                  <input class="form-check-input" type="checkbox"><span class="label-text"></span>
                </label>
              </div>
              <div class="btn-group">
                <button class="btn btn-primary btn-sm" type="button"><i class="bi bi-trash fs-5"></i></button>
                <button class="btn btn-primary btn-sm" type="button"><i class="bi bi-reply fs-5"></i></button>
                <button class="btn btn-primary btn-sm" type="button"><i class="bi bi-share fs-5"></i></button>
                <button class="btn btn-primary btn-sm" type="button" @click.prevent="listarMensajes(1)"><i class="bi bi-arrow-clockwise fs-5"></i></button>
              </div>
            </div>
        <template v-if="listado == 0">
            <div class="table-responsive mailbox-messages">
                    <table class="table table-hover">
                        <tbody>
                        <tr v-for="leidas in noleidas" :key="leidas.id">
                            <td><a href="#"><i class="bi bi-star"></i></a></td>
                            <td class="mail-subject"><b>{{ leidas['data'].title }}</b> - {{ leidas['data'].description }}</td>
                            <td>{{ Math.round((new Date()- new Date(leidas['data'].created_at))/ (1000 * 60))}}</td>
                        </tr>
                        </tbody>
                    </table>
            </div>
            <nav class="text-end">
                <ul class="pagination">
                    <li class="page-item" v-if="pagination.current_page > 1">
                        <a class="page-link btn btn-primary btn-sm" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                    </li>
                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                        <a class="page-link btn btn-primary btn-sm" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </template>
        <template v-if="listado == 1">
            <div class="table-responsive mailbox-messages">
                    <table class="table table-hover">
                        <tbody>
                        <tr v-for="mensaje in arrayMensajes" :key="mensaje.id">
                            <td><a href="#"><i class="bi bi-star"></i></a></td>
                            <td class="mail-subject"><b>{{ mensaje.title }}</b> - {{ mensaje.description }}</td>
                            <td v-if=" Math.round((new Date()- new Date(mensaje.created_at))/ (1000 * 60))>60">
                                hace {{ Math.round((new Date()- new Date(mensaje.created_at))/ (1000 * 60 * 60))}} hr(s).
                            </td>
                            <td v-if=" Math.round((new Date()- new Date(mensaje.created_at))/ (1000 * 60))<60">
                                hace {{ Math.round((new Date()- new Date(mensaje.created_at))/ (1000 * 60))}} min.
                            </td>
                        </tr>
                        </tbody>
                    </table>
            </div>
            <nav class="text-end">
                <ul class="pagination">
                    <li class="page-item" v-if="pagination.current_page > 1">
                        <a class="page-link btn btn-primary btn-sm" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                    </li>
                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                        <a class="page-link btn btn-primary btn-sm" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </template>
        <template v-if="listado == 2">
            <div class="tile">
            <h3 class="tile-title">Nuevo Mensaje</h3>
            <div class="tile-body">
              <form class="form-horizontal">
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Titulo</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="title" placeholder="Escriba un Titulo" v-model="titulo">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Descripción</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="description" placeholder="Escriba una Descripción" v-model="descripcion">
                  </div>
                </div>
              </form>
            </div>
            <div class="tile-footer">
              <div class="row">
                <div v-show="errorMensaje" class="form-group row div-error col-md-8 col-md-offset-3">
                    <div class="text-center text-error">
                        <div v-for="error in errorMostrarMensaje" :key="error" v-text="error">

                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-md-offset-3">
                  <button class="btn btn-primary" type="button" @click="enviar()"><i class="bi bi-check-circle-fill me-2"></i>Enviar</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" @click.prevent="cancel()"><i class="bi bi-x-circle-fill me-2"></i>Cancel</a>
                </div>
              </div>
            </div>
          </div>
        </template>     

          </div>
        </div>
      </div>
    </main>
</template>
<script>
import { shallowReadonly } from 'vue';

export default {
        data (){
            return {
                titulo:'',
                descripcion:'',
                listado : 0,
                noleidas : [],
                errorMensaje : [],
                errorMostrarMensaje : [],
                arrayMensajes : [],
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
        methods:{
            enviados(){this.listado=1},
            listarMensajes(page){

                let me = this;
                axios.get('/posts?page=' + page).then((response)=>{
                    var respuesta = response.data;
                    console.log(respuesta);
                    me.arrayMensajes = respuesta.mensajes.data;
                    me.noleidas = respuesta.noleidas;
                    me.pagination = respuesta.pagination;
                }).catch((error)=>{
                    console.log(error.response.data);
                })
            },
            enviar(){
                let me = this;
                if (me.validarenvio()){return;}
                axios.post('/posts/crear',{
                    'title' : me.titulo,
                    'description' : me.descripcion,
                }).then((response)=>{
                    swal.fire(response.data.message,'','success');
                    me.cancel();
                }).catch((error)=>{
                    console.log(error.response.data);
                })
            },
            redactar(){
                this.listado = 2;
            },
            cambiarPagina(page){
                let me = this;
                me.pagination.current_page = page;
                me.listarMensajes(page);
            },
            cancel(){
                this.listado = 0;
                this.titulo = '';
                this.descripcion = '';
                this.errorMensaje = [];
                this.errorMostrarMensaje = [];
            },
            validarenvio(){
                let me=this;
                me.errorMensaje=0;
                me.errorMostrarMensaje =[];
                
                let validText = /^[ a-zA-ZñÑáéíóúÁÉÍÓÚ0-9]+$/;

                if (me.titulo == null || me.titulo.length == 0 || !validText.test(me.titulo)) me.errorMostrarMensaje.push("El titulo es incorrecto");
                if (me.descripcion == null || me.descripcion.length == 0 || !validText.test(me.descripcion)) me.errorMostrarMensaje.push("La descripción es incorrecta");
                             
                if (me.errorMostrarMensaje.length) me.errorMensaje = 1;
                return me.errorMensaje;
            }
        },
        mounted(){
            this.listarMensajes(1);
        },
    }
</script>