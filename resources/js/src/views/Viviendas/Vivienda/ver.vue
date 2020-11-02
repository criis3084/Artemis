<template>
  <div id="item-detail-page">
    <vx-card title="Información de la vivienda">


      <template slot="no-body">
				<vs-divider position="right">PID&#174;</vs-divider>

        <div class="item-content">

          <!-- Item Main Info -->
          <div class="product-details p-6">
            <div class="vx-row mt-6">
                


              <div class="vx-col md:w-2/5 w-full flex items-center justify-center">
                <div class="product-img-container w-3/5 mx-auto mb-10 md:mb-0">
                  <img src="https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/products/01.png" :alt="this.imagen_finalT" class="responsive">

                  <!--
                    UnComment Below line for true flow
                    <img :src="item_data.image" :alt="item_data.name" class="responsive">

                    Remove above img tag which is for demo purpose in actual flow
                  -->
                </div>
              </div>




              <div class="vx-col md:w-3/5 w-full">
                    <vx-tooltip text="Regresar"><vs-button size="small" @click="goBack" class="mr-4" type="border" icon-pack="feather" icon="icon-corner-up-left" radius></vs-button></vx-tooltip>

                <span>Destinatario</span>
                <p class="flex items-center flex-wrap">
                <vx-tooltip text="Nombre de encargado"><span class="material-icons ">person</span></vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4 mt-2">{{ this.encargado_nombres2 + " " + this.encargado_apellidos2 }}</span>
                </p>
                <span>Constructor</span>
                <p class="flex items-center flex-wrap">
                <vx-tooltip text="Nombre de constructor"><span class="material-icons ">person_outline</span></vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4 mt-2">{{ this.constructor_nombres2 + " " + this.constructor_apellidos2 }}</span>
                </p>

                <vs-divider />
                <span>Información adicional</span>
                <p class="flex items-center flex-wrap">
                  <vx-tooltip text="Tipo de vivienda"><span class="material-icons ">house_siding</span></vx-tooltip>
                  <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.tipo_vivienda_idT}}</span>
                </p>
                <p class="flex items-center flex-wrap">
                  <vx-tooltip text="Dirección"><span class="material-icons ">place</span></vx-tooltip>
                  <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.direccionT }}</span>
                </p>
                <p class="flex items-center flex-wrap"> 
                   <vx-tooltip text="Fecha de inicio"> <span class="material-icons ">calendar_today </span> </vx-tooltip>
                    <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.fecha_inicioT }}</span>
                </p>

                <p class="flex items-center flex-wrap"> 
                   <vx-tooltip text="Meses de duración"> <span class="material-icons ">date_range </span> </vx-tooltip>
                    <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.duracionT }}</span>
                </p>

                <p class="flex items-center flex-wrap">
                      <vx-tooltip text="Costo total"> <span class="material-icons ">money</span> </vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4"> {{currency(this.costo_totalT) }}</span>
                </p>
                <vs-divider/>
                
                <div class="vx-row">
                  <div class="vx-col flex flex-wrap items-center">
                   <vx-tooltip text="Editar Información"> <vs-button class="mr-4" type="gradient" icon-pack="feather" color="success" icon="icon-edit"  @click="$router.push('/editar/vivienda/'+id_recibido)">Editar Información</vs-button> </vx-tooltip>
                    <vx-tooltip text="Regresar"><vs-button @click="goBack" class="mr-4" type="gradient" icon-pack="feather" icon="icon-corner-up-left">Regresar</vs-button></vx-tooltip>
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
import 'swiper/dist/css/swiper.min.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import algoliasearch from 'algoliasearch/lite'
import StarRating from 'vue-star-rating'
import axios from 'axios'

export default{
  components: {
    swiper,
    swiperSlide,
    StarRating
  },
  data () {
    return {
      duracionT: "",
      direccionT: "",
      fecha_inicioT:this.getDate(this.fecha_inicio),
      imagen_finalT:'',
      costo_totalT:'',
      encargadosT: [],
        encargado_idT:'',
     constructorsT: [],
       constructor_idT:'',
      tipoViviendasT: [],
        tipo_vivienda_idT:'',
        encargado_nombres2:'',
        encargado_apellidos2:'',
        constructor_nombres2:'',
        constructor_apellidos2:'',
        tipo_nombre:'',
        vivienda_nombreT:'',
      id_recibido:''

      // Related Products Swiper
      // Below is data which is common in any item
      // Algolia's dataSet don't provide this kind of data. So, here's dummy data for demo
    }
  },
  computed: {
  },
  methods: {
    goBack(){
      this.$router.go(-1)
    },
    async index(page, search){ //async para que se llame cada vez que se necesite
        let me = this;
        this.id_recibido = this.$route.params.id;
        
        console.log("criterio   "+this.id_recibido);
		const response = await axios.get(
			`/api/vivienda/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
		.then(function (response) {
			console.log(page)
			var respuesta= response.data;
              me.arrayData = respuesta.viviendas.data[0];
              me.duracionT = me.arrayData.duracion;
              me.imagen_finalT = me.arrayData.imagen_final;
              me.direccionT = me.arrayData.direccion;
              me.costo_totalT = me.arrayData.costo_total;
              me.fecha_inicioT = me.arrayData.fecha_inicio;
              me.encargado_nombres2 = me.arrayData.datos_residente[0].nombres;
              me.encargado_apellidos2 = me.arrayData.datos_residente[0].apellidos;
              me.constructor_nombres2 = me.arrayData.datos_constructor[0].nombres;
              me.constructor_apellidos2 = me.arrayData.datos_constructor[0].apellidos;
              me.tipo_vivienda_idT = me.arrayData.tipo_vivienda.nombre;
            console.log(me.arrayData);
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
    },
    getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
      },
       currency(numero) {
        let formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'GTQ',
        });
        let mil = formatter.format(numero);
        return mil;
    },
  },
  created () {
  },
 	mounted(){
    this.index(1, this.search);
    },
}
</script>

<style lang="scss">

@import "@sass/vuexy/_variables.scss";

#item-detail-page {
  .color-radio {
    height: 2.28rem;
    width: 2.28rem;

    > div {
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  }

  .item-features {
    background-color: #f7f7f7;

    .theme-dark & {
      background-color: $theme-dark-secondary-bg;
    }
  }

  .product-sales-meta-list {
    .vs-list--icon {
      padding-left: 0;
    }
  }

  .related-product-swiper {
      // padding-right: 2rem;
      // padding-left: 2rem;

    .swiper-wrapper {
      padding-bottom: 2rem;

      > .swiper-slide {
        background-color: #f7f7f7;
        box-shadow: 0 4px 18px 0 rgba(0,0,0,0.1), 0 5px 12px 0 rgba(0,0,0,0.08) !important;

        .theme-dark & {
          background-color: $theme-light-dark-bg;
        }
      }
    }

    .swiper-button-next,
    .swiper-button-prev {
      transform: scale(.5);
      filter: hue-rotate(40deg);
    }

    .swiper-button-next {
      right: 0
    }

    .swiper-button-prev {
      left: 0;
    }
  }
}
</style>
