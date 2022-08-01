// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.6.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
    apiKey: "AIzaSyDnrhYqRzHsh1eAMYxv2oBvh6crG8gZYzw",
    authDomain: "lebudigital-c0249.firebaseapp.com",
    databaseURL:
        "https://lebudigital-c0249-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "lebudigital-c0249",
    storageBucket: "lebudigital-c0249.appspot.com",
    messagingSenderId: "122232958487",
    appId: "1:122232958487:web:5d004e0f87a36a0f537652",
    measurementId: "G-QLS07RVW3Z",
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

console.log('FIREBASE MESSAGING SW ....');
console.log(messaging);

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