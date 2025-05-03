<template>
    <div>
        <Navbar />
        <!-- Other components and content -->
    </div>
    <!-- <h2>Welcome, {{ session.username }}</h2>
    <p>Emp No: {{ session.empno }}</p>
    <p>Department: {{ session.department }}</p>
    <p>Section: {{ session.sec }}</p>
    <p>Permission: {{ session.permission }}</p>
    <p>MSECT ID: {{ session.MSECT_ID }}</p>
    <p>Server: {{ session.server }}</p> -->
    <div class="container max-w-full mx-auto">

        <router-view></router-view>

    </div>
</template>

<script>
import Navbar from './Navbar.vue';
export default {
  components: {
    Navbar
  },
  data() {
    return {
      session: this.$session // Access the global session object
    };
  }
};

</script>
