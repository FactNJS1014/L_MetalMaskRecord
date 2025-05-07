<template>
  <div>
    <Navbar />

    <div class="flex justify-start mt-4 ms-20">
      <button @click="handleClick" class="bg-blue-500 hover:bg-blue-600 text-white font-bold rounded py-3 px-2">
        Manual Page
      </button>
    </div>

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

    <router-view>

    </router-view>

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
  },
  mounted() {
    console.log('session:', this.session);
    // if (this.$route.path === '*') {
    //   this.$router.push('/');
    // }
    // if(this.$session.permission == '1'){
    //   this.$router.push('/reportChange');
    // }
   
  },
  methods: {
    handleClick() {
      // Handle the button click event
      window.location.href = 'http://172.22.64.11/45_engmask/';
    }
  }
};

</script>
