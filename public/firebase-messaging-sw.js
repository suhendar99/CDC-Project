/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/8.2.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');
   
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
        apiKey: "AIzaSyDIwI2rySPgRjg2tc5WG3-i9-WS_QBZUiA",
        authDomain: "laravel-push-notif-53ca2.firebaseapp.com",
        databaseURL: "https://laravel-push-notif-53ca2-default-rtdb.firebaseio.com",
        projectId: "laravel-push-notif-53ca2",
        storageBucket: "laravel-push-notif-53ca2.appspot.com",
        messagingSenderId: "186579738404",
        appId: "1:186579738404:web:1149f45244cd92fca75db1",
        measurementId: "G-SQ9WLBCMV7"
    });
  
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };
  
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});