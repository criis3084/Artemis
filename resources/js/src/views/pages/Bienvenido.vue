
<template>
    <div class="h-screen flex w-full bg-img">
        <div class="vx-col w-4/5 sm:w-4/5 md:w-3/5 lg:w-3/4 xl:w-3/5 mx-auto self-center">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row">
                        <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/3 mx-auto self-center">
                            <!-- <img src="@assets/images/pages/forgot-password.png" alt="login" class="mx-auto"> -->
							<!-- En la linea de abajo cambias la imagen maco -->
							<img :src="'/storage/public/bienvenida/logo.png'" alt="bienvenido" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center d-theme-dark-bg">
                            <div class="p-8">
                                <div class="vx-card__title mb-">
                                    <h1 class="mb-4">Bienvenido</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>

<script>
import 'swiper/dist/css/swiper.min.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'

export default {
		data(){
			return{
				swiperOption: {
					spaceBetween: 130,
					centeredSlides: true,
					autoplay: {
						delay: 3500,
						disableOnInteraction: false
					},
					pagination: {
						el: '.swiper-pagination',
						clickable: true
					},
					navigation: {
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev'
					}
				}
			}
		},
		components: {
			swiper,
			swiperSlide
		}
    }
</script>