<template>
    <div>
        <Navbar />
        <!-- Other components and content -->
    </div>
    <div class="container max-w-full mx-auto">

        <router-view></router-view>

    </div>
</template>

<script>
import Navbar from './Navbar.vue';

export default {
    components: {
        Navbar,
    },
};
</script>
