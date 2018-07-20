
<template>
<div v-if = "!offFunction">

  <q-layout>

   <q-page-container>
  <q-page padding class="row justify-center">
      <div style="width: 500px; max-width: 90vw;">
        <q-list highlight>
          <q-list-header>Recent chats</q-list-header>
          <template v-for="(user, index) in friendListsFilter">

          <q-item  @click.native="selectFriend(user.id, user.chatroute, user, index)">
            <q-item-side avatar="https://picsum.photos/80/80" />
            <q-item-main :label="user.en_name" />
            <q-item-side right icon="chat_bubble" color="green" />

          </q-item>



        </template>
          <q-item-separator />
          <q-list-header>Previous chats</q-list-header>
          <q-item>
            <q-item-side avatar="https://picsum.photos/80/80" />
            <q-item-main label="Jack Doe" />
          </q-item>
        </q-list>
      </div>
      </q-page>

    </q-page-container>
  </q-layout>

</div>

<div v-else>
  <q-layout>
    <q-btn @click="$router.push({ name: 'SomePage' })" style= "background-color: transparent;"  icon="arrow back"></q-btn>
   <q-page-container>
     <q-page class="chat-page q-ma-xl"  >

       <template  v-for="(item, index) in myMessages">

       <q-chat-message
         :name="item.name"
         avatar="https://picsum.photos/80/80"
         :text="[item.message]"
         stamp="4 minutes ago"
         sent
      ></q-chat-message>

</template>




     </q-page>


   </q-page-container>

 </q-layout>
 <q-input
          color="dark"
          type="textarea"
          ref="message"
          class="row col-12 fixed-bottom full-width chat-message bg-white""
         style="z-index: 1001; margin-top: 16px;   overflow: auto;
           overflow-x: hidden; :max-height:20; "
          v-model="message"
          float-label="What's your message?"
          @input="notifyClientIsTyping(), visualizeMessage()"
          @focus="visualizeMessage()"
          @keyup.enter="submit()"
          :before="[{icon: 'arrow_back', handler () {}}]"
          :after="[
             { icon: 'cloud upload', handler() { submit() } },
          {  icon: 'send', handler() { submit() } }


          ]"

        />

<q-uploader :url="url" />
</div>


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

   area: '',

   friendLatestMessage: [],

   query: '',

       max: 5,
       footer: '',
       url: '',


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
       vm.$router.push('/chatglobal/' + chatroute)



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

.chat-page{


    max-height: 80vh;

    overflow: auto;
    overflow-x: hidden;
    margin-bottom: 20px;

}

::-webkit-scrollbar {
    display: none;
}

.chat-message .q-icon {
  margin-right: 10px;
}



  </style>
