(function(){
  // Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyAEZ5nzUn3ERKhoZWWLg75yevckfS1rzFM",
  authDomain: "u-near-me-457b8.firebaseapp.com",
  databaseURL: "https://u-near-me-457b8-default-rtdb.firebaseio.com",
  projectId: "u-near-me-457b8",
  storageBucket: "u-near-me-457b8.appspot.com",
  messagingSenderId: "90267080922",
  appId: "1:90267080922:web:389c66600124f51d0cede3",
  measurementId: "G-YLSSJV5WBM"
};
  // Initialize Firebase
  if (!firebase.apps.length) {
    firebase.initializeApp(firebaseConfig);
  }
  //firebase.analytics();

  // Auth and Firestore references
  // const auth = firebase.auth();
  // const db = firebase.firestore();
  //const strg = firebase.storage();
  
  // Update firestore settings
})();
