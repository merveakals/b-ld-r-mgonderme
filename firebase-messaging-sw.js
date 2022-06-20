importScripts('https://www.gstatic.com/firebasejs/8.1.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.1.2/firebase-messaging.js');

firebase.initializeApp({
  apiKey           : "",
  authDomain       : "",
  projectId        : "",
  storageBucket    : "",
  messagingSenderId: "",
  appId            : ""
});


const messaging = firebase.messaging();