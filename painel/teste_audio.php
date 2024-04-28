<!DOCTYPE html>
<html>
  
<head>
  <script>
  
    let audioIN = { audio: true };
    //  audio is true, for recording
  
    // Access the permission for use
    // the microphone
    navigator.mediaDevices.getUserMedia(audioIN)
  
      // 'then()' method returns a Promise
      .then(function (mediaStreamObj) {
  
        // Connect the media stream to the
        // first audio element
        let audio = document.querySelector('audio');
        //returns the recorded audio via 'audio' tag
  
        // 'srcObject' is a property which 
        // takes the media object
        // This is supported in the newer browsers

        // if ("srcObject" in audio) {
        //   audio.srcObject = mediaStreamObj;
        // }
        // else {   // Old version
        //   audio.src = window.URL
        //     .createObjectURL(mediaStreamObj);
        // }
  
        // It will play the audio
        audio.onloadedmetadata = function (ev) {
  
          // Play the audio in the 2nd audio
          // element what is being recorded
        //   audio.play();
        };
  
        // Start record
        let start = document.getElementById('btnStart');
  
        // Stop record
        let stop = document.getElementById('btnStop');
  
        // 2nd audio tag for play the audio
        let playAudio = document.getElementById('adioPlay');
  
        // This is the main thing to recorde 
        // the audio 'MediaRecorder' API
        let mediaRecorder = new MediaRecorder(mediaStreamObj);
        // Pass the audio stream 
  
        // Start event
        start.addEventListener('click', function (ev) {
          mediaRecorder.start();
          // console.log(mediaRecorder.state);
        })
  
        // Stop event
        stop.addEventListener('click', function (ev) {
          mediaRecorder.stop();
          // console.log(mediaRecorder.state);
        });
  
        // If audio data available then push 
        // it to the chunk array
        mediaRecorder.ondataavailable = function (ev) {
          dataArray.push(ev.data);
        }
  
        // Chunk array to store the audio data 
        let dataArray = [];
  
        // Convert the audio data in to blob 
        // after stopping the recording
        mediaRecorder.onstop = function (ev) {
  
          // blob of type mp3
          let audioData = new Blob(dataArray, 
                    { 'type': 'audio/mp3;' });
            
          // After fill up the chunk 
          // array make it empty
          dataArray = [];
  
          // Creating audio url with reference 
          // of created blob named 'audioData'
          let audioSrc = window.URL
              .createObjectURL(audioData);
  
          // Pass the audio url to the 2nd video tag
          playAudio.src = audioSrc;
        }
      })
  
      // If any error occurs then handles the error 
      .catch(function (err) {
        console.log(err.name, err.message);
      });
  </script>
</head>
  
<body style="background-color:rgb(101, 185, 17); ">
  <header>
    <h1>Record and Play Audio in JavaScript</h1>
  </header>
  <!--button for 'start recording'-->
  <p>
    <button id="btnStart">START RECORDING</button>
                
    <button id="btnStop">STOP RECORDING</button>
    <!--button for 'stop recording'-->
  </p>
  
  <!--for record-->
  <!-- <audio controls></audio> -->
  <!--'controls' use for add 
    play, pause, and volume-->
  
  <!--for play the audio-->
  <audio id="adioPlay" controls></audio>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
/* Estilos do microfone */
.microfone {
  width: 100px;
  height: 100px;
  background-color: transparent;
  border-radius: 50%;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Estilos do ícone de microfone */
.icon {
  color: white;
  font-size: 48px;
  z-index:1;
}

/* Estilos do "rádio luminoso" */
.radio {
  width: 200px;
  height: 200px;
  background-color: red;
  border-radius: 50%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  animation: radio-pulse 1s ease-in-out infinite alternate;
}

/* Animação do "rádio luminoso" */
@keyframes radio-pulse {
  0% {
    width: 20px;
    height: 20px;
  }
  100% {
    width: 50px;
    height: 50px;
    opacity: 0;
  }
}
</style>

<div class="microfone">
  <div class="radio"></div>
  <i class="icon fas fa-microphone"></i>
</div>


</body>
  
</html>