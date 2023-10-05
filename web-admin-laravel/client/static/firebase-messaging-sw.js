
    importScripts(
      'https://www.gstatic.com/firebasejs/9.8.4/firebase-app-compat.js'
    )
    importScripts(
      'https://www.gstatic.com/firebasejs/9.8.4/firebase-messaging-compat.js'
    )
    firebase.initializeApp({"apiKey":"AIzaSyDbtefXCERsgSJTn1Lm403PmfdQVw163Us","authDomain":"nictus-multivendor.firebaseapp.com","projectId":"nictus-multivendor","storageBucket":"nictus-multivendor.appspot.com","messagingSenderId":"880697357247","appId":"1:880697357247:web:da59f900a25152202b670a","measurementId":"G-WMD05ZMCMG"})

    // Retrieve an instance of Firebase Messaging so that it can handle background
    // messages.
    const messaging = firebase.messaging()

    