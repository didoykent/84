<template id="">

<div>

  <q-layout>

    <q-toolbar>
       <q-btn flat round dense icon="menu"   @click="drawer = !drawer" />
       <q-toolbar-title>
         Toolbar
       </q-toolbar-title>
       <q-btn flat round dense icon="more_vert" />

    <q-layout-drawer v-model="drawer">
      <q-scroll-area class="fit">
           <q-list-header>Left Panel</q-list-header>
           <q-item to="student-login" v-if = "!isLogged">
             <q-item-side icon="account circle" />
             <q-item-main label="Play " sublabel="Login" />
             <q-item-side right icon="thumb_up" />
           </q-item>

           <q-item to="student-logout"  v-if = "isLogged">
             <q-item-side icon="account circle" />
             <q-item-main label="Play " sublabel="LogOut" />
             <q-item-side right icon="thumb_up" />
           </q-item>
            </q-scroll-area>
</q-layout-drawer>
 </q-toolbar>



  <router-view></router-view>

    </q-layout>









</div>


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




    tmData.append('myData', JSON.stringify(response.data));




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
