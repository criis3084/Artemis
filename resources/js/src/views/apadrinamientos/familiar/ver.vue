<template>
<div id="item-detail-page">
    <vx-card title="Información del familiar">


      <template slot="no-body">
				<vs-divider position="right">PID&#174;</vs-divider>

        <div class="item-content">

          <!-- Item Main Info -->
          <div class="product-details p-6">
            <div class="vx-row mt-6">
              <div class="vx-col md:w-2/5 w-full flex items-center justify-center">
                <div class="product-img-container w-3/5 mx-auto mb-10 md:mb-0">
                  <img :src="this.ruta_imagenT" :alt="this.ruta_imagenT" class="responsive">

                </div>
              </div>

              <!-- Item Content -->
              <div class="vx-col md:w-3/5 w-full">
                    <vs-button @click="goBack" size="small" class="mr-4" type="border" radius icon-pack="feather" color="primary" icon="icon-corner-up-left"></vs-button>

                <span>Nombres y apellidos</span>
                <h1 class="text-2xl leading-none font-medium text-primary mr-4 mt-2">{{ this.nombresT +" " + this.apellidosT }}</h1>
                 <!-- <br> -->
                <span>CUI</span>
               <h1 class="text-2xl leading-none font-medium text-primary mr-4 mt-2">{{this.cuiT }}</h1>

                <vs-divider />
                <span>Datos Personales</span>
                <p class="flex items-center flex-wrap">
                  <vx-tooltip text="Dirección"><span><vs-icon icon="house" size="medium" color="dark"></vs-icon></span></vx-tooltip>
                  <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.direccionT }}</span>
                </p>
                <p class="flex items-center flex-wrap">
                  <vx-tooltip text="Sector"><span><vs-icon icon="place" size="medium" color="dark"></vs-icon></span></vx-tooltip>
                  <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.sector_idT }}</span>
                </p>
                <p class="flex items-center flex-wrap"> 
                   <vx-tooltip text="Télefono"> <span><vs-icon icon="call" size="medium" color="dark"></vs-icon></span> </vx-tooltip>
                    <span class="text-2xl leading-none font-medium text-primary mr-4">{{this.numero_telefono }}</span>
                </p>
                <p class="flex items-center flex-wrap">
                      <vx-tooltip text="Fecha de nacimiento"> <span> <vs-icon icon="cake" size="medium" color="dark"></vs-icon></span> </vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.fecha_nacimientoT }}</span>
                </p>

                <vs-divider />
                <span>Información adicional</span>
                
                <p class="flex items-center flex-wrap">
                    <vx-tooltip text="Escolaridad"> <span><vs-icon icon="school" size="medium" color="dark"></vs-icon></span> </vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.escolaridadT}}</span>
                </p>
                 <p class="flex items-center flex-wrap">
                    <vx-tooltip text="Ocupación"> <span><vs-icon icon="work" size="medium" color="dark"></vs-icon></span> </vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.ocupacionT}}</span>
                </p>
                 <p class="flex items-center flex-wrap">
                    <vx-tooltip text="Ingresos"> <span><vs-icon icon="money" size="medium" color="dark"></vs-icon></span> </vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4"> {{currency (this.ingresosT)}}</span>
                </p>
                <vs-divider/>
                
                <div class="vx-row">
                  <div class="vx-col flex flex-wrap items-center">
                   <vs-button class="mr-4" type="gradient" icon-pack="feather" color="success" icon="icon-edit" @click="$router.push('/editar/familiar/'+id_recibido)">Editar Información</vs-button>  
                    <vs-button @click="goBack" class="mr-4" type="gradient" icon-pack="feather" color="primary" icon="icon-corner-up-left"> Regresar</vs-button>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>

      </template>
    </vx-card>
  </div>
</template>

<script>

import axios from 'axios'

export default {
  data () {
    return {
      nombresT: '',
      apellidosT: '',
      direccionT: '',
      fecha_nacimientoT: '',
      cuiT: '',
	  generoT:'',
      ingresosT:'',
      ocupacionT:'',
      escolaridadT:'',
	  ruta_imagenT:'',
	  sector_idT:0,
	 
      numero_telefono:'',
      id_recibido:''
    }
  },
  methods: {
    currency (numero) {
      const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'GTQ'
      })
      const mil = formatter.format(numero)
      return mil
    },
    goBack(){
      this.$router.go(-1)
    },
	  getDate (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
    },
    async index (page, search) { //async para que se llame cada vez que se necesite
      const me = this
      this.id_recibido = this.$route.params.id
      console.log(`criterio   ${this.id_recibido}`)
      const response = await axios.get(
        `/api/encargado/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
        .then(function (response) {
          console.log(page)
          var respuesta = response.data;
            me.arrayData = respuesta.encargados.data[0];
            me.nombresT = me.arrayData.datos.nombres;
            me.apellidosT = me.arrayData.datos.apellidos;
            me.direccionT = me.arrayData.datos.direccion;
            me.numero_telefono = me.arrayData.datos.numero_telefono;
            me.idT = me.arrayData.datos.id;
            me.cuiT = me.arrayData.datos.CUI;

            me.generoT = me.arrayData.datos.genero;
            me.ruta_imagenT = me.arrayData.ruta_imagen;
            me.fecha_nacimientoT = me.arrayData.datos.fecha_nacimiento;
        
            me.sector_idT = me.arrayData.datos.sector_id;
            me.ocupacionT = me.arrayData.ocupacion;
            me.ingresosT = me.arrayData.ingresos;
            me.escolaridadT = me.arrayData.escolaridad;
            me.persona_sin_acceso_idT = me.arrayData.datos.persona_sin_acceso_id;
            console.log(me.nombresT);
            console.log(me.arrayData);
        me.pagination = respuesta.pagination;
        })
        .catch(function (error) {
          console.log(error)
        });
    },
  },
  mounted () {
    this.index(1, this.search)
  }
}
</script>