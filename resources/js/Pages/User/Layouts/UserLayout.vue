<template>
    <Header></Header>

    <slot/>

    <Footer></Footer>
</template>

<script setup>
    import Header from './Header.vue';
    import Footer from './Footer.vue';
    import {onMounted} from 'vue';
    import {initFlowbite} from 'flowbite';


    onMounted(() => {
        initFlowbite()
    })
</script>