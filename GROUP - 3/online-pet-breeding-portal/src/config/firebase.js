import firebase from 'firebase/app'
import 'firebase/auth';
import 'firebase/firestore';
import "firebase/storage";
// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
// V1 Database

// const firebaseConfig = {
//   apiKey: "AIzaSyBSv9HopUsX9sPJFYgXXPVutDZRb00xf9o",
//   authDomain: "online-pet-breeding-portal.firebaseapp.com",
//   databaseURL: "https://online-pet-breeding-portal-default-rtdb.firebaseio.com",
//   projectId: "online-pet-breeding-portal",
//   storageBucket: "online-pet-breeding-portal.appspot.com",
//   messagingSenderId: "226815505780",
//   appId: "1:226815505780:web:e7281150cddd62a366e821",
//   measurementId: "G-N353CXPEDN"
// };

const firebaseConfig = {
  apiKey: "AIzaSyALuSSu7nCJ1vDFGBtsrOe53VXo6Rd6W6U",
  authDomain: "pet-society-dd946.firebaseapp.com",
  projectId: "pet-society-dd946",
  storageBucket: "pet-society-dd946.appspot.com",
  messagingSenderId: "1055367244829",
  appId: "1:1055367244829:web:9871bbcba24f8f4ba8eaf4"
};

// const firebaseConfig = {
//   apiKey: "AIzaSyD2BSwFA0oPRqVYCBfwIesnGBM_aZs3zzQ",
//   authDomain: "pet-breeding-v2-test.firebaseapp.com",
//   projectId: "pet-breeding-v2-test",
//   storageBucket: "pet-breeding-v2-test.appspot.com",
//   messagingSenderId: "186630187680",
//   appId: "1:186630187680:web:31da848fadef8b8b25b7c5"
// };

export const firebaseApp = firebase.initializeApp(firebaseConfig);
export const auth = firebase.auth();
export const storage = firebase.storage();
const db = firebase.firestore();

export default db;
