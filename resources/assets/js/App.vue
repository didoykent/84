<template id="">

    <q-layout>

     <q-page-container>

  <q-toolbar color="primary" class="fixed-top full-width z-top">
       <q-btn @click="$router.push({ name: 'SomePage' })" color="secondary" icon="arrow back"></q-btn>

    <!--
      For Toolbar title, we use
      QToolbarTitle component
    -->



   <q-layout-drawer v-model="drawer">
     <q-scroll-area class="fit">

          <q-item to="student-login" v-if = "!isLogged">
            <q-item-side icon="account circle" />
            <q-item-main label="Play " sublabel="Login" />
            <q-item-side right icon="thumb_up" />
          </q-item>

          <q-item @click.native = "studentLogOut"  v-if = "isLogged">
            <q-item-side icon="account circle" />
            <q-item-main label="Play" sublabel="LogOut" />
            <q-item-side right icon="thumb_up" />
          </q-item>
           </q-scroll-area>
  </q-layout-drawer>

  <q-toolbar-title>
         Toolbar
       </q-toolbar-title>


       <q-btn flat round dense icon="menu"   @click="drawer = !drawer" />
  </q-toolbar>


  <router-view></router-view>

</q-page-container>

</q-layout>












</template>


<script>

import axios from 'axios'

import {mapState , mapGetters} from 'vuex'

export default{





  data(){

    return{

      myData : '',
      search: '',
       drawer: true
    }
  },

computed:{

...mapGetters([

  'isLogged'
])
},
beforeMount(){


},



  methods:{

    testIn(){
var vm =  this
      axios.get('api/getStudents').then(function(response){



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




    tmData.append('myData', JSON.stringify(response.data));









    axios.post('api/getTmData', tmData).then(function(response){


    }).catch(function(error){

      console.log(error)
    })



          var waa = response.data

        })
        },

    studentLogOut(){

      var vm  = this



      vm.$store.dispatch('studentLogOut')

                vm.$socket.disconnect();


    }
  }
}

</script>
