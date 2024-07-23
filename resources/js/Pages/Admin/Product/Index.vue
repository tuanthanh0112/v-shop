<template>
    <AdminLayout>

            <FormPro></FormPro>
       <ProductList :products="products"></ProductList>
    </AdminLayout>
</template>

<script setup>

defineProps({
    products:Array
})
import AdminLayout from '../Components/AdminLayout.vue';
import ProductList from '../Product/ProductList.vue';
import FormPro from '../Components/Form/Form.vue';
</script>