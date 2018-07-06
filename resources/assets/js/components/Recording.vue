<template>

  <v-container grid-list-md text-xs-center>
  <v-layout row wrap>
   <v-flex  xs12 sm6 offset-sm3>
  <v-card style="text-align: center">

        <v-card-text>

          <v-btn outline icon class="error--text" @click.native = "playing? pause(): play()">

            <v-icon v-if="playing === false || paused === true">play_arrow</v-icon>

      <v-icon v-else>pause</v-icon>


                    </v-btn>

                    <v-slider    @click.native="setPosition()" v-model="percentage" color = "error" :disabled="loaded === true"></v-slider>

        <p>{{ currentTime }} / {{ duration }} </p>
        </v-card-text>

  <audio  ref="player" v-on:ended="ended" :src="file"></audio>

</v-card>

<v-card>
            <v-divider></v-divider>
  <v-list two-line>
  <v-list-tile avatar ripple  @click="">
            <v-list-tile-content>
              <v-list-tile-title>Title : Frozen</v-list-tile-title>


            </v-list-tile-content>
            <v-list-tile-action>

              <v-icon color="pink">star_border</v-icon>
            </v-list-tile-action>


          </v-list-tile>
                    <v-divider></v-divider>

          <v-list-tile avatar ripple  @click="">
                    <v-list-tile-content>
                      <v-list-tile-title>Book Page : 27</v-list-tile-title>


                    </v-list-tile-content>
                    <v-list-tile-action>

                      <v-icon color="pink">star_border</v-icon>
                    </v-list-tile-action>
                  </v-list-tile>


                </v-list-tile>
                          <v-divider></v-divider>

                <v-list-tile avatar ripple  @click="">
                          <v-list-tile-content>
                            <v-list-tile-title>Teacher: Sally</v-list-tile-title>


                          </v-list-tile-content>
                          <v-list-tile-action>

                            <v-icon color="pink">star_border</v-icon>
                          </v-list-tile-action>
                        </v-list-tile>



                      </v-list-tile>
                                <v-divider></v-divider>

                      <v-list-tile avatar ripple  @click="">
                                <v-list-tile-content>
                                  <v-list-tile-title>Student : Mina</v-list-tile-title>


                                </v-list-tile-content>
                                <v-list-tile-action>

                                  <v-icon color="pink">star_border</v-icon>
                                </v-list-tile-action>
                              </v-list-tile>




         </v-list>





         <v-divider></v-divider>

</v-card>


<v-card style="text-align: center">

      <v-card-text>

        <form enctype="multipart/form-data" @submit.prevent = "sendRecording">

          <div v-if = "uploadProgress">
            <v-progress-circular
          :size="30"
          :width="15"
          :rotate="90"
          :value="uploadProgress"
          color="red"
          >
          {{uploadProgress}}
          </v-progress-circular>

          </div>

          <div v-else>

        <div v-if="!myFile['file']">

           <input class="file-input" type="file" ref="file" name="file" @change="addFile()">
         </div>
         <div v-else>



           <v-btn raised  type  = "submit" class="error"  >
             Submit
       </v-btn>
       <v-btn raised class="primary" @click.native="removeFile">
         Remove
        </v-btn>
         </div>

         </div>

         </form>

    </v-card-text>

</v-card>


</v-flex>




</v-layout>

</v-container>

</template>


<script>
 import axios from 'axios'
const formatTime = (secend) => {

    let time = new Date(secend * 1000).toISOString().substr(11, 8)

    return time

}

export default {

  props:{

    canPlay: {

              type: Function,

              default: () => {},

          },

          ended: {

              type: Function,

              default: () => {},

          },
  },

  data(){

    return{

      file: './storage/SAAMQf3Uy3P4wIeRb0gpkCxyV41PtFtILz7Sbsx8.mpga',
      audio: undefined,
      playing: false,
      paused: false,
      percentage: 0,
      currentTime: '00:00:00',
      totalDuration: 0,
      isMuted: false,
      loaded: false,
      mp3:'',
      myFile: {name:null, file:null},

      formData: {},

    uploadProgress: 0









    }
  },

  computed: {

    duration(){

      return this.audio ? formatTime(this.totalDuration): ''
    }
  },

  methods:{




    init: function () {



              this.audio.addEventListener('pause', this._handlePlayPause);

              this.audio.addEventListener('play', this._handlePlayPause);

              this.audio.addEventListener('timeupdate', this._handlePlayingUI);

              this.audio.addEventListener('ended', this._handleEnded);




          },

          setPosition () {

              this.audio.currentTime = parseInt(this.audio.duration / 100 * this.percentage);



          },

          _handlePlayPause: function (e) {

              if (e.type === 'pause' && this.paused === false && this.playing === false) {

                  this.currentTime = '00:00:00'

              }

          },

          _handlePlayingUI: function (e) {

          this.percentage = parseInt(this.audio.currentTime / this.audio.duration * 100)
            this.totalDuration = parseInt(this.audio.duration)
          this.currentTime = formatTime(this.audio.currentTime)
          console.log(formatTime(this.audio.currentTime))

      },

      _handleEnded () {

              this.paused = this.playing = false;

          },


          play(){

              if (this.playing) return

            this.paused = false

              this.audio.play()

              this.playing = true


          },

          pause () {

              this.paused = !this.paused;

              (this.paused) ? this.audio.pause() : this.audio.play()

          },

    addFile(){
var vm  = this
          vm.myFile.file = this.$refs.file.files[0];

          console.log(vm.myFile.file)
    },

          removeFile(){

            var vm = this

            vm.myFile.file = ''
          },

          sendRecording(){
              var vm = this
              vm.uploadProgress = 1
            let config = {
                 onUploadProgress(progressEvent) {
                  var percentCompleted = Math.round((progressEvent.loaded * 100) /
                    progressEvent.total);



                  vm.uploadProgress = parseInt(percentCompleted)
                },

              }



            vm.formData = new FormData();

            vm.formData.append('file', vm.myFile.file)


            axios.post('api/audio_recording', vm.formData, config





            ).then(function(response){

                console.log(response.data)
                vm.uploadProgress = 0
                vm.myFile.file = ''
            }).catch(function(error){

              console.log(error)
            })


          }



  },





  mounted(){

              this.audio = this.$refs.player;
                this.init();
  }
}


</script>
