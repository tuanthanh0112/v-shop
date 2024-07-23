<script setup>

import { onMounted } from 'vue'
import {Link, router, usePage} from '@inertiajs/vue3';
import { initFlowbite } from 'flowbite'
import UserLayout from './Layouts/UserLayout.vue';
import Hero from './Layouts/Hero.vue';
import Products from '../User/Components/Products.vue';
 defineProps({
    products:Array
 })
// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>

<template>

  <UserLayout>
    <Hero></Hero>
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
          <h2 class="text-2xl font-bold tracking-tight text-gray-900">List of products</h2>
  
          <!-- product list component -->
  
          <Products :products="products"></Products>
          

          <div class="flex mt-5 justify-center">
            <Link :href="route('products.index')"  class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">View all product</Link>
          </div>
  
  
      </div>
    </div>
  </UserLayout>
  
</template>
