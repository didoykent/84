<template>


<v-app dark>

<div v-if = "!offFunction">
  <v-flex xs12>






       <v-text-field v-model = "query"

          placeholder="Search..."


        solo
        >



        </v-text-field>



</v-flex>

  <v-container grid-list-md text-xs-center>






        </v-flex>

   <v-subheader text-md-center>Active Users</v-subheader>
<v-layout row wrap>
   <v-card flat style="background-color:transparent;">
             <v-card-text class="overflow-hidden py-0">
  <v-layout row align-content-center class="horiz-scroll">





    <v-flex    v-for="(user, index) in friendListsFilter" :key="user.en_name" @click="selectFriend(user.id, user.chatroute, user, index)"
                     px-1
                     pb-2
                   >
                      <div class="pos-relative">



                         <v-list style="background-color:transparent;">


 </v-list-tile-avatar>
     <img :src="'https://placeimg.com/200/200/arch'"  >

     <span :class = "{green: user.isActive, grey: !user.isActive}" style="  height: 15px;
         width: 15px;

         border-radius: 50%;
           z-index: 1;

       transform: translate(15px, -15px);


         display: inline-block;"></span>



</v-list>

 <v-list-tile   v-html="user.en_name" style="    display: inline-block;   list-style-type: none;  transform: translateY(-10px); max-width:50px; ">     </v-list-tile>
          </v-list>



 </div>






                   </v-flex>










</v-layout>
</v-card-text>
      </v-card>







</v-layout row align-content-center >


<v-flex xs6>
<v-subheader text-md-center>Users</v-subheader>

  </v-flex>




  <v-flex class ="scrollable">
   <v-list two-line   style="background-color:transparent;">
          <template v-for="(item, index) in friendLatestMessage" >



            <div class = "adjust-container">
            <v-list-tile :key="item.en_name" avatar @click="">

                <img :src="'https://placeimg.com/200/200/animals'">

                <div class  = "dot">
                     <span :class = "{green: item.isActive, grey: !item.isActive}" style="  height: 15px;
                         width: 15px;

                         border-radius: 50%;
                           z-index: 1;

                       transform: translate(-16px, 18px);

                         display: inline-block;"></span>
                   </div>


              <v-list-tile-content>
                <v-list-tile-title>{{item.en_name}}</v-list-tile-title>
                <v-list-tile-sub-title>{{item.latestmessage}}</v-list-tile-sub-title>
              </v-list-tile-content>
              <v-list-tile-action top>

                  <v-list-tile-sub-title  class = "text-lg-right" v-html="">{{item.created_at}}</v-list-tile-sub-title>
            </v-list-tile-action>
            </v-list-tile>

        </div>
          </template>
        </v-list>
      </v-flex>

</v-container>

</div>

<div v-else>


              <v-flex xs12 >


  <div  class="suggested">

    <v-list  class = "suggested-list">


      <v-list-tile

    v-for="(item, index) in myMessages"
    :key="index"
    avatar
    @click=""
    >



    <v-list-tile-avatar>
    <img :src="item.avatar">
    </v-list-tile-avatar>

    <v-list-tile-content style="height:auto;">
    <h2 v-html="item.name"></h2>

                      <v-list-tile-sub-title style = "word-break:break-all;   white-space: normal;
  overflow: visible;
  text-overflow: unset; ">{{ item.message }}</v-list-tile-sub-title>


    </v-list-tile-content>





    </v-list-tile>



            </v-list>

            <audio id="player" ref="player" value = "hidden" :src="file"></audio>
           </div>







    </v-flex>
   <v-layout row wrap style="transform: translateY()">
    <v-flex xs10>
      <textarea   v-model="message" @keyup.enter = "sendMessage"
    							rows="5"
    							style="width: 100%;
                  border: none;

                  height: 80%;"




    							placeholder="Type a message" >
    						</textarea>

    </v-flex>


    <v-flex xs2 >
      <button type = "button"  @click = "sendMessage" style="width: 100%; height: 100%; background-color:#009688;">Send</button>

    </v-flex>

  </v-layout>

</div>
</v-app>

</template>


<script>

import Vue from 'vue'
import axios from 'axios'
import {mapGetters} from 'vuex'
export default{


data(){
  return {

    mediaList: [
         {id: 1, name: "lover", src: "https://placeimg.com/200/200/animals"},
   {id: 2, name: "fdfdfdfdfd", src: "https://placeimg.com/200/200/arch"},
   {id: 3, name: "fdfdfdfd", src: "https://placeimg.com/200/200/nature"},
   {id: 1, name: "lover", src: "https://placeimg.com/200/200/animals"},
{id: 2, name: "fdfdfdfdfd", src: "https://placeimg.com/200/200/arch"},
{id: 3, name: "fdfdfdfd", src: "https://placeimg.com/200/200/nature"},
{id: 1, name: "lover", src: "https://placeimg.com/200/200/animals"},
{id: 2, name: "fdfdfdfdfd", src: "https://placeimg.com/200/200/arch"},
{id: 3, name: "fdfdfdfd", src: "https://placeimg.com/200/200/nature"},
{id: 1, name: "lover", src: "https://placeimg.com/200/200/animals"},
{id: 2, name: "fdfdfdfdfd", src: "https://placeimg.com/200/200/arch"},
{id: 3, name: "fdfdfdfd", src: "https://placeimg.com/200/200/nature"},


 ],

 friendLatestMessage: [],

 query: '',

     max: 5,


inbox: [

         { avatar: 'https://placeimg.com/200/200/arch', title: 'Brunch this weekend?', subtitle: "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?" },

         { avatar: 'https://placeimg.com/200/200/people', title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>', subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend." },

         { avatar: 'https://placeimg.com/200/200/nature', title: 'Oui oui', subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?" },

         { avatar: 'https://placeimg.com/200/200/tech', title: 'Brunch this weekend?', subtitle: "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?" },

         { avatar: 'https://placeimg.com/200/200/animals', title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>', subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend." },

         { avatar: 'https://placeimg.com/200/200/animals', title: 'Oui oui', subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?" },

         { avatar: 'https://placeimg.com/200/200/animals', title: 'Brunch this weekend?', subtitle: "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?" },

         { avatar: 'https://placeimg.com/200/200/animals', title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>', subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend." },

         { avatar: 'https://placeimg.com/200/200/animals', title: 'Oui oui', subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?" },


       ],

       Active: true,

       data: [],
         busy: false,

       items: [
                { header: 'Today' },
                { avatar: 'https://scontent.ficn2-1.fna.fbcdn.net/v/t1.0-1/p160x160/29468236_901369833374211_8734349036217171968_n.jpg?_nc_cat=0&oh=f8f7428a3e9e807d58b3ef91ef215062&oe=5B760837', title: 'Brunch this weekend?', subtitle: "  I'll be in your neighborhood doing errands this weekend. Do you want to hang out?", name: '' },
                { divider: true, inset: true },

              ],



              users: [
              { active: true, title: 'Priscilla', avatar: 'https://scontent.ficn2-1.fna.fbcdn.net/v/t1.0-9/26734343_1963222710598716_4444436793604184869_n.jpg?_nc_cat=0&oh=7d16dfb49268afd4c548d37a9f4a6f77&oe=5B373C24' },
              { active: true, title: 'Ranee Carlson', avatar: '/static/doc-images/lists/2.jpg' },
              { title: 'Cindy Baker', avatar: '/static/doc-images/lists/3.jpg' },
              { title: 'Ali Connors', avatar: '/static/doc-images/lists/4.jpg' },
              { active: true, title: 'Jason Oner', avatar: '/static/doc-images/lists/1.jpg' },
              { active: true, title: 'Ranee Carlson', avatar: '/static/doc-images/lists/2.jpg' },
              { title: 'Cindy Baker', avatar: '/static/doc-images/lists/3.jpg' },
              { title: 'Ali Connors', avatar: '/static/doc-images/lists/4.jpg' },
              { active: true, title: 'Jason Oner', avatar: '/static/doc-images/lists/1.jpg' },
              { active: true, title: 'Ranee Carlson', avatar: '/static/doc-images/lists/2.jpg' },
              { title: 'Cindy Baker', avatar: '/static/doc-images/lists/3.jpg' },
              { title: 'Ali Connors', avatar: '/static/doc-images/lists/4.jpg' },
              { active: true, title: 'Jason Oner', avatar: '/static/doc-images/lists/1.jpg' },
              { active: true, title: 'Ranee Carlson', avatar: '/static/doc-images/lists/2.jpg' },
              { title: 'Cindy Baker', avatar: '/static/doc-images/lists/3.jpg' },
              { title: 'Ali Connors', avatar: '/static/doc-images/lists/4.jpg' }
            ],
            users2: [
              { title: 'Travis Howard', avatar: '/static/doc-images/lists/5.jpg' }
            ],

            message: '',


             myMessages:{


               messages: [

                 { header: 'Today' },
                 { avatar: 'https://scontent.ficn2-1.fna.fbcdn.net/v/t1.0-1/p160x160/29468236_901369833374211_8734349036217171968_n.jpg?_nc_cat=0&oh=f8f7428a3e9e807d58b3ef91ef215062&oe=5B760837', title: 'Brunch this weekend?', subtitle: "  I'll be in your neighborhood doing errands this weekend. Do you want to hang out?" },
                 { divider: true, inset: true }

               ]
             },







             myFriends:[],



             myLatestMessage: [],

             currentUser: '',
             secondUser: '',
             tempMessage: '',
             messageStorage: [],

             messageValue: 0,
             tempName: '',
             currentUserName: '',
             secondUserName: '',
             currentUserId : '',
             currentUserRole: '',
             initializeMessage: -20,
             isActive: true,
             file: undefined,
             audio: undefined,
             scrollValue: 20,
             max: false,

             offFunction: false,
             tempArray: []


     }

     },

     computed: {
    // mix the getters into computed with object spread operator
    ...mapGetters([
      'isLogged'

      // ...
    ]),
    friendListsFilter: function(){

              var vm = this

             return vm.searchFor(vm.myFriends, vm.query, 'en_name')
           }

  },

     watch:{




     },







     mounted(){


     var vm= this


       vm.$socket.on('sendMessage', function(data){
       vm.myMessages.push({'avatar' : 'https://scontent.ficn2-1.fna.fbcdn.net/v/t1.0-1/p160x160/29468236_901369833374211_8734349036217171968_n.jpg?_nc_cat=0&oh=f8f7428a3e9e807d58b3ef91ef215062&oe=5B760837', 'name': vm.secondUserName, 'message': data.message})
     var myData = data.messagedata
     var connected = false
     var messageCount = 0;



     for( var i=0; i<data.clientsData.length; i++){

       if(data.clientsData[i] === data.bonusdata ){
         connected = true
       axios.put(`/api/editMessage/${myData}`).then(function(response){


         vm.scrollToEnd()


       }).catch(function(error){

         console.log(error)
       })

       }
     }





       }.bind(this))

       vm.$socket.on('messageNotification', function(data){


     var vm = this
      console.log('test')
     console.log('myunread',data)


     for(var i =0; i<vm.myFriends.length; i++){




       if(vm.myFriends[i]['id'] === data.bonusdata){

         Vue.set(vm.myFriends[i], 'notif', vm.myFriends[i]['notif'] +=1)

         console.log( 'krname', data.myunread.friend['kr_name'])


         console.log(data.myunread.currentUserName)

       }

          let nameToFindIndex = vm.friendLatestMessage.findIndex(p => p.en_name === data.myunread.currentUserName)


          Vue.set(vm.friendLatestMessage[nameToFindIndex], 'latestmessage', data.myunread.message)


      let nameToChangeAndSwap = vm.friendLatestMessage.find(p => p.en_name === data.myunread.currentUserName)
     let originalIndex = vm.friendLatestMessage.findIndex(p => p.en_name === data.myunread.currentUserName)

     vm.friendLatestMessage.splice(originalIndex, 1)
     vm.friendLatestMessage.unshift({
       ...nameToChangeAndSwap,
       name: data.myunread.currentUserName
     })

}






       }.bind(this))

       vm.$socket.on('yourFriend', function(data){

         let myFriend = data



     if(data !=null){

         for(var i =0; i<vm.myFriends.length; i++){





           if (vm.myFriends[i]['id'] === myFriend){



               Vue.set( vm.myFriends[i], 'isActive', true)


           }






         }

       }











       }.bind(this))



     vm.$socket.on('Now', function(data){
       if(vm.isLogged){


       vm.socketOp = new FormData();

       vm.socketOp.append('socketId', vm.$socket.id)

       axios.post('api/initializeData', vm.socketOp).then(function(response){


       for(var i =0; i<vm.myFriends.length; i++){

         if(vm.myFriends[i]['id'] === data.currentUserId){

           Vue.set(vm.myFriends[i], 'current_conn_id', data.mySocket)
           Vue.set(vm.myFriends[i], 'previous_conn_id', data.mySocket)

           if(vm.getUserSock['id'] === data.currentUserId){

             Vue.set(vm.getUserSock, 'current_conn_id', data.mySocket)
             Vue.set(vm.getUserSock, 'previous_conn_id', data.mySocket)
           }

         }



       }




       }).catch(function(error){


       })
       }

     }.bind(this))





     vm.$socket.on('userDisconnected', function(data){

     vm.friendLists()

       let myFriend = data





       for(var i =0; i<vm.myFriends.length; i++){





         if (vm.myFriends[i]['previous_conn_id'] === data ||  vm.myFriends[i]['current_conn_id'] === data){



             Vue.set( vm.myFriends[i], 'isActive', false)


         }






       }

     }.bind(this))


     },





     beforeMount(){
     var vm = this





     this.friendLists()


     },


     methods:{


     getTestData(){

     axios.get('api/testData').then(function(response){



     }).catch(function(error){


       console.log(error)
     })

     },


     searchFor: function (list, value, column) {
           return list.filter(function (item) {
             return item[column].includes(value)
           })
         },


     initScroll(){
     var vm = this

     var container = vm.$el.querySelector('.suggested > .list ')
     container.addEventListener("scroll", ()=>{

     if(container.scrollTop === 0 && vm.max === false){


       vm.myFriend = new FormData();


       vm.myFriend.append('secondUser', vm.secondUser)
       vm.myFriend.append('scrollValue', vm.scrollValue)

       axios.post('/api/getMessages', vm.myFriend).then(function(response){


       vm.max = response.data.max

       console.log(response.data.scrollValue)




       Vue.set(vm.$data, 'myMessages', response.data.messages)


       vm.scrollValue+=20
       vm.currentUserName = response.data.currentUserName
       vm.secondUserName = response.data.secondUserName




       }).catch(function(error){

         console.log(error)
       })




     }





     })


   },











     sendMessage(){

     var vm  = this


     vm.message = vm.message.replace(/(\w{29})$/, '$1 ');
     vm.tempMessage = vm.message
     console.log('char length', vm.message.length)
     vm.myMessages.push({'avatar' : 'https://scontent.ficn2-1.fna.fbcdn.net/v/t1.0-1/p160x160/29468236_901369833374211_8734349036217171968_n.jpg?_nc_cat=0&oh=f8f7428a3e9e807d58b3ef91ef215062&oe=5B760837', 'name': vm.currentUserName, 'message': vm.message})







       vm.formData = new FormData();


       vm.formData.append('secondUser', vm.secondUser)
       vm.formData.append('message', vm.tempMessage)

       axios.post('api/saveMessage', vm.formData).then(function(response){



     vm.$socket.emit('latestMessage', {message: vm.message, friend: vm.getUserSock, messagedata: response.data, bonusdata: vm.$socket.id, secondUser: vm.secondUser, myId: vm.currentUserId, currentUserName: vm.currentUserName})

     vm.scrollToEnd()
     vm.message = ''


       }).catch(function(error){

         console.log(error)
       })


     },



     scrollToEnd () {
       var vm = this
             var container = vm.$el.querySelector('.suggested > .list ')
             container.scrollTop = container.scrollHeight


           },

           loadMore: function() {
           this.busy = true;

           setTimeout(() => {
             for (var i = 0, j = 10; i < j; i++) {
               this.data.push({ name: count++ });
             }
             this.busy = false;
           }, 1000);
         },







       async friendLists(){



     var vm = this

     if(vm.isLogged){


     vm.$socket.connect()


     }

          await axios.get('api/getFriendLists').then(function(response){

            console.log('waa',response.data.unreadMessages)

            Vue.set(vm.$data, 'friendLatestMessage', response.data.friendLatestMessage)
            Vue.set(vm.$data, 'myLatestMessage', response.data.myLatestMessage)

                 console.log('mylatest', vm.myLatestMessage)
                 console.log('friendlist', response.data.friendLists)
       let unreadMessages = response.data.unreadMessages
     Vue.set(vm.$data, 'myFriends', response.data.friendLists)
     for(var i =0; i<vm.myFriends.length; i++){
       Vue.set(vm.myFriends[i],'notif',unreadMessages[i+1])

     }



     vm.currentUserId = response.data.currentUserId
     vm.currentUserRole = response.data.role

     vm.$socket.emit('ImOn', {currentUserId: vm.currentUserId, mySocket: vm.$socket.id, friend: response.data.currentUser})

     setInterval(function(){

     vm.$socket.emit('friendOnline', vm.currentUserId)
     }, 2000);


           }).catch(function(error){

             console.log(error)
           })



         },

          getUnreadMessages(){

           var vm = this

            axios.get('api/getUnreadMessages').then(function(response){
             let unreadMessages = response.data.allUnread


             for(var i =0; i<vm.myFriends.length; i++){
               Vue.set(vm.myFriends[i],'notif',unreadMessages[i+1])

             }



           }).catch(function(error){

             console.log(error)
           })

         },


         selectFriend(id, chatroute, item, index){

     var vm = this
     vm.max = false
     vm.scrollValue = 20
     vm.offFunction = true
     vm.$router.push('/android-chat/' + chatroute)



     vm.secondUser = id
     vm.getUserSock = item

     let currentUserId = vm.currentUserId
     let role = vm.currentUserRole
     vm.$socket.emit('roomdata', {firstUser: currentUserId.toString(), secondUser: id.toString(), currentRole: role, mySocketId: vm.$socket.id})


     vm.myFriend = new FormData();


     vm.myFriend.append('secondUser', id)
     vm.myFriend.append('scrollValue', vm.scrollValue)

     axios.post('/api/getMessages', vm.myFriend).then(function(response){


       console.log('my messages', response.data.messages)

     console.log(response.data.scrollValue)
       console.log('messages length', response.data.messages.length)
     vm.max = response.data.max

     Vue.set(vm.$data, 'myMessages', response.data.messages)


     vm.scrollValue+=20
     vm.currentUserName = response.data.currentUserName
     vm.secondUserName = response.data.secondUserName


     if(vm.myMessages){

     Vue.set(vm.myFriends[index], 'notif', 0)

     vm.scrollToEnd()


     vm.initScroll()

     }

     }).catch(function(error){

       console.log(error)
     })








   }

 }
}




</script>

<style>




body{

  position: fixed;
  overflow-y: hidden;
  top: 0; right: 0; bottom: 0; left: 0;

}

.overflow-hidden {
  overflow: hidden;

}
.horiz-scroll {
  overflow-y: hidden;
  overflow-x: auto;
  max-width: 55vh;

},


.vert-scroll{

  overflow-x: hidden;
  overflow-y: auto;

}


.scrollable{

  overflow-x: hidden;
  overflow-y: auto;
  max-height: 55vh;

}

::-webkit-scrollbar {
    display: none;
}


img {
display:block;

max-width:46px;
max-height: 46px;
border-radius: 50%;



}

.dot {

}

.green{

    background-color: #C0CA33;


}

.gray{


    background-color: #2E7D32;

}

.adjust-container{

  transform: translateY(-20px);
}

.suggested > .list {


   overflow-y: auto;
height: calc(100vh - 9.5rem);

width: 100%;


}




</style>
