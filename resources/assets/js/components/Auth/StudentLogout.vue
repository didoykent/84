<template>


  <h2>Logged Out</h2>
</template>


<script>

import axios from 'axios'
export default{


  data(){

    return{


    }
  },

  beforeMount(){
    var vm  = this



    vm.$store.dispatch('studentLogOut')
              vm.$socket.disconnect();
              localStorage.removeItem('sacket');

  },

  methods:{


  }
}


</script>
