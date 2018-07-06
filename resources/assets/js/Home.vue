<template>


  <div>

  <v-app>
    <v-toolbar  color="pink" >
      <v-toolbar-side-icon></v-toolbar-side-icon>
      <v-toolbar-title>Megatalking</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items class="hidden-sm-and-down">
        <v-btn flat   :to = "'student-login'">Login|</v-btn>
        <v-btn flat :to = "'student-register'">Register</v-btn>
        <v-btn flat>LogOut</v-btn>
      </v-toolbar-items>
    </v-toolbar>

    <router-view></router-view>
  </v-app>


  </div>
</template>


<script>
import axios from 'axios'

export default{

data(){


  return{


  }
},


beforeMount(){

this.testData()
},

methods:{


  testData(){


    axios.get('api/getAllStudents').then(function(response){

console.log(response.data)

}).catch(function(error){

  console.log(error)
})

  }
}

}


</script>
