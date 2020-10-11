<template>
    <div id="ecommerce-checkout-demo">
        <form-wizard
            ref="checkoutWizard"
            color="rgba(var(--vs-primary), 1)"
            :title="null"
            :subtitle="null"
            :hide-buttons="true">

            <!-- tab 1 content -->
            <tab-content title="Cart" icon="feather icon-shopping-cart" class="mb-5">

                <!-- IF CART HAVE ITEMS -->
                <div class="vx-row">

                    <!-- LEFT COL -->
                    <div class="vx-col lg:w-2/3 w-full">
                        <div class="items-list-view">
                            <item-list-view :item="item" class="mb-base">

                                <!-- SLOT: ITEM META -->
                                <template slot="item-meta">
                                    <!-- <h6 class="item-name font-semibold mb-1 cursor-pointer hover:text-primary">{{  }}</h6> -->
                                    <p class="text-sm mb-2">Destinatario: <span class="font-semibold cursor-pointer">{{ this.encargado_nombres + ' ' + this.encargado_apellidos }}</span></p>
                                    <p class="text-sm mb-2">Constructor: <span class="font-semibold cursor-pointer">{{ this.constructor_nombres + ' ' + this.constructor_apellidos }}</span></p>
                                    
                                    <p class="text-danger text-sm">In Stock</p>

                                    <p class="text-sm mb-2">Dirección: <span class="font-semibold cursor-pointer" >{{ this.direccionT }}</span></p>
                                    <p class="text-sm mb-2">Costo total: <span class="font-semibold cursor-pointer">{{ this.costo_totalT }}</span></p>

                                </template>

                                <!-- SLOT: ACTION BUTTONS -->
                                <template slot="action-buttons">

                                    <!-- PRIMARY BUTTON: REMOVE -->
                                    <div class="item-view-primary-action-btn p-3 rounded-lg flex flex-grow items-center justify-center cursor-pointer mb-3" @click="$router.push('/ver/vivienda/'+id_recibido)">
                                        <feather-icon icon="HomeIcon" svgClasses="h-4 w-4" />
                                        <span class="text-sm font-semibold ml-2">Ver vivienda</span>
                                    </div>

                                    <div class="item-view-primary-action-btn p-3 rounded-lg flex flex-grow items-center justify-center cursor-pointer mb-3" @click="$router.push('/ver/vivienda/'+id_recibido)">
                                    <vs-button class="mt-4" @click.prevent="makePayment" :disabled="false">CONTINUE</vs-button>
                                    </div>
                                    
                                    <!-- SECONDARY BUTTON: MOVE-TO/VIEW-IN WISHLIST -->
                                    <!-- <div class="item-view-secondary-action-btn bg-primary p-3 rounded-lg flex flex-grow items-center justify-center text-white cursor-pointer" @click="wishListButtonClicked(item)">
                                        <feather-icon icon="HeartIcon" :svgClasses="[{'text-white fill-current': isInWishList(item.objectID)}, 'h-4 w-4']" />
                                        <span class="text-sm font-semibold ml-2" v-if="isInWishList(item.objectID)">WISHLIST</span>
                                        <span class="text-sm font-semibold ml-2" v-else>WISHLIST</span>
                                    </div> -->
                                </template>
                            </item-list-view>
                        </div>
                    </div>

                    <!-- RIGHT COL -->
                    <div class="vx-col lg:w-1/3 w-full">
                        <vx-card>
                            <p class="text-grey mb-3">Options</p>
                            <div class="flex justify-between">
                                <span class="font-semibold">Coupons</span>
                                <span class="font-medium text-primary cursor-pointer">Apply</span>
                            </div>

                            <vs-divider />

                            <p class="font-semibold mb-3">Price Details</p>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Total MRP</span>
                                <span>$598</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Bag Discount</span>
                                <span class="text-success">-25$</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Estimated Tax</span>
                                <span>$1.3</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">EMI Eligibility</span>
                                <a href="#" class="text-primary">Details</a>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Delivery Charges</span>
                                <span class="text-success">Free</span>
                            </div>

                            <vs-divider />

                            <div class="flex justify-between font-semibold mb-3">
                                <span>Total</span>
                                <span>$574.3</span>
                            </div>

                            <vs-button class="w-full">PLACE ORDER</vs-button>
                        </vx-card>
                    </div>
                </div>

            </tab-content>

           

        </form-wizard>
    </div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
const ItemListView = () => import('./components/ItemListView.vue')
import axios from 'axios'

export default {
  data () {
    return {
      //VIVIENDA
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
        encargado_nombres:'',
        encargado_apellidos:'',
        constructor_nombres:'',
        constructor_apellidos:'',
      id_recibido:'',
      // TAB 2
      fullName: '',
      mobileNum: '',
      pincode: '',
      houseNum: '',
      area: '',
      landmark: '',
      city: '',
      state: '',
      addressType: 1,
      addressTypeOptions: [
        { text: 'Home', value: 1 },
        { text: 'Office', value: 2 }
      ],

      // TAB 3
      paymentMethod: 'debit-card',
      cvv: ''
    }
  },
  computed: {

  },
  methods: {
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
    // async index(page, search){ //async para que se llame cada vez que se necesite
    //     let me = this;
	// 	this.id_recibido = this.$route.params.id
	// 	const response = await axios.get(
	// 		`/api/historialAbonoVivienda/get?&criterio=vivienda_id&buscar=${me.id_recibido}&completo=true`)
	// 	.then(function (response) {
	// 		var respuesta= response.data;
    //         me.arrayData = respuesta.historialAbonoViviendas.data;
	// 		me.pagination= respuesta.pagination;

	// 	})
	// 	.catch(function (error) {
	// 		console.log(error);
	// 	});
    // },
     async index2(page, search){ //async para que se llame cada vez que se necesite
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
              me.encargado_nombres = me.arrayData.datos_residente[0].nombres;
              me.encargado_apellidos = me.arrayData.datos_residente[0].apellidos;
              me.constructor_nombres = me.arrayData.datos_constructor[0].nombres;
              me.constructor_apellidos = me.arrayData.datos_constructor[0].apellidos;
              me.tipo_vivienda_idT = me.arrayData.tipo_vivienda.nombre;
            console.log(me.arrayData);
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
    },  

    // TAB 3
    makePayment () {
      return new Promise(() => {
        this.$validator.validateAll('cvv-form').then(result => {
          if (result) {
            // if form have no errors
            this.$vs.notify({
              title: 'Success',
              text: 'Payment received successfully',
              color: 'success',
              iconPack: 'feather',
              icon: 'icon-check'
            })
          } else {
            this.$vs.notify({
              title: 'Error',
              text: 'Please enter valid details',
              color: 'warning',
              iconPack: 'feather',
              icon: 'icon-alert-circle'
            })
          }
        })
      })
    },
  },
  components: {
    ItemListView,
    FormWizard,
    TabContent
  },
  mounted(){
    // this.index(1, this.search);
    this.index2(1, this.search);
  },
}
</script>

<style lang="scss" scoped>
#ecommerce-checkout-demo {
    .item-view-primary-action-btn {
        color: #2c2c2c !important;
        background-color: #f6f6f6;
    }

    .item-name {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
    }

    .vue-form-wizard {
        padding-bottom: 0;

        ::v-deep .wizard-header {
            padding: 0;
        }

        ::v-deep .wizard-tab-content {
            padding-right: 0;
            padding-left: 0;
            padding-bottom: 0;

            .wizard-tab-container{
              margin-bottom: 0 !important;
            }
        }
    }
}
</style>
