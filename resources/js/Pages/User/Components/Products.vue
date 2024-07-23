
<script setup>
import { useToast } from 'vue-toastification';
import {Link, router, usePage} from '@inertiajs/vue3';

defineProps({
    products:Array
 })

const toast = useToast();

const addToCart = (product) => {
  router.post(route('cart.store', product), {})
  toast.success('added product')
}


</script>
<template>
 
  <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
    <div v-for="product in products" :key="product.id" class="group relative">
      <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
        <img v-if="product.product_image.length > 0"  :src="`/${product.product_image[0].image}`" :alt="product.product_image.image" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
        <img v-else src="https://st4.depositphotos.com/14953852/24787/v/450/depositphotos_247872612-stock-illustration-no-image-available-icon-vector.jpg" :alt="product.product_image.image" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer" >
          <a @click="addToCart(product)" class="bg-blue-700 p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" @click="addToCart(product)">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
          </a>
        </div>
      </div>
      <div class="mt-4 flex justify-between">
        <div>
          <h3 class="text-sm text-gray-700">
            <a :href="product.href">
              <span aria-hidden="true" class="absolute inset-0" />
              {{ product.title }}
            </a>
          </h3>
          <p class="mt-1 text-sm text-gray-500">{{ product.brand.name }}</p>
          <a href="" @click="addToCart(product)" class="absolute inset-0 flex items-end justify-end">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
          </a>
        </div>
        <p class="text-sm font-medium text-gray-900">$ {{ product.price }}</p>
        
      </div>
      <ul class="inline-flex items-stretch -space-x-px">
                        <li v-if="currentPage > 0">
                            <a @click="previousPage()"
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li v-else></li>
                        <li  v-for=" ( page, index ) in customPagination"   >
                            <a v-if=" Math.abs(index - currentPage) < 3 || index == 0 || index == totalPage - 1" @click="changePage(index)"   :class=" {current:  currentPage === index, last: ( index == totalPage - 1 && Math.abs(index - currentPage) > 3),
                                    first:(index == 0 && Math.abs(index - currentPage)>3)}"
                                class="flex items-center cursor-pointer justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    {{ index + 1 }}
                            </a>
                        </li>
                        <li v-if="(currentPage + 1) * rowsLimit < productLists?.length">
                            <a @click="nextPage()"
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li v-else></li>
                    </ul>
    </div>
  </div>
</template>