 // Import the functions you need from the SDKs you need
 import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
 import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-analytics.js";
 // TODO: Add SDKs for Firebase products that you want to use
 // https://firebase.google.com/docs/web/setup#available-libraries

 // Your web app's Firebase configuration
 // For Firebase JS SDK v7.20.0 and later, measurementId is optional
 const firebaseConfig = {
   apiKey: "AIzaSyAFQMfAKP72UPCbZ8qMwul8luKYbyzqoaY",
   authDomain: "covid-runner-f54c7.firebaseapp.com",
   databaseURL: "https://covid-runner-f54c7-default-rtdb.firebaseio.com",
   projectId: "covid-runner-f54c7",
   storageBucket: "covid-runner-f54c7.appspot.com",
   messagingSenderId: "549760676524",
   appId: "1:549760676524:web:931f3771ee96087a54e509",
   measurementId: "G-4TPXQ6G961"
 };

 // Initialize Firebase
 const app = initializeApp(firebaseConfig);
 const analytics = getAnalytics(app);