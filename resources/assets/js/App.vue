<template id="">

<div>

<v-app>
  <v-toolbar  color="pink" >
    <v-toolbar-side-icon></v-toolbar-side-icon>
    <v-toolbar-title>Megatalking</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-sm-and-down">


      <v-btn flat :to = "'student-login'" v-if = "!isLogged" >Login|</v-btn>
      <v-btn flat :to = "'student-register'"  v-if = "!isLogged">Student</v-btn>
      <v-btn flat :to = "'tutor-register'"  v-if = "!isLogged">Tutor</v-btn>





        </v-toolbar-items>

    <v-toolbar-items class="hidden-sm-and-down">

      <v-btn flat @click="studentLogOut" v-if = "isLogged">LogOut</v-btn>
      <v-btn flat @click="testIn" v-if = "isLogged">testData</v-btn>
        </v-toolbar-items>

  </v-toolbar>




  <router-view></router-view>


</v-app>




</div>


</template>


<script>

import axios from 'axios'
import {mapGetters} from 'vuex'
export default{

  data(){

    return{

      myData : ''
    }
  },

computed:mapGetters([

  'isLogged'
]),

beforeMount(){

  this.koreaData()
},



  methods:{

    testIn(){
var vm =  this
      axios.get('api/getStudents').then(function(response){

        console.log(response.data)

      }).catch(function(error){

        console.log(error)
      })
    },


    koreaData(){

      var data = new FormData();
data.append('idx', 'all');

    axios.post('https://phone.megatalking.com/api/get_list4chat_json.php', data).then(function(response){

var myData = response.data


let newobj = Object.values(myData)

var newArray = [], i = 0;

for(var i = 0; i<newobj.length; i++){

  newArray[i] = newobj[i]
}

var tmData = new FormData();
tmData.append('myData', newArray[0]);




console.log('objtoArray', newobj.length)

console.log('newArray', typeof(newArray))




axios.post('api/getTmData', tmData).then(function(response){

console.log('tmData', response.data.tmData)
}).catch(function(error){

  console.log(error)
})

      console.log(response.data)

      var waa = response.data

      console.log('that', waa.length)
      console.log('myData', myData)
    })
    },

    studentLogOut(){

      var vm  = this



      vm.$store.dispatch('studentLogOut')
                vm.$socket.disconnect();
                localStorage.removeItem('sacket');


    }
  }
}

</script>
