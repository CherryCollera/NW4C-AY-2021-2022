const db = firebase.firestore();
const auth = firebase.auth();
var tour_id, sid;
// Firebase Authentication
auth.onAuthStateChanged(function(user) {
    if(user){
        // Check if School ID is existing
        getSchoolID(user.uid);
        $('.email-nav').text(`${user.email}`);
        
    } else {
        window.location.assign("/index.html");
    }
});
function getSchoolID(uid){
    db.collection('school_admin').doc(uid).onSnapshot( function(snapshot){
        if (snapshot.data().school_id) {
            
            sid = snapshot.data().school_id;
            db.collection('schools').doc(sid).onSnapshot(function (snapshot) {
               if(snapshot.data().tour_id){
                   tour_id = snapshot.data().tour_id;
                   loadTour();
             
               } else {
                window.location.assign("new.html");
               }
            }) 
        } else {
            // 
        }
    }); 
}
        function loadTour(){
            // Load up containers
            const container = document.querySelector("div[data-container-id='tours']");
            db.collection("tours").doc(tour_id).get().then((doc) => {
                //let size = querySnapshot.size;
        
                // if (size > 0) {
                //     document.querySelector("#newTour").parentElement.remove();
                // }
                
                    const data = doc.data();
                    container.innerHTML += `<div class="border p-2 align-items-center">
                <div>
                    <h1 class="text-2xl font-bold">${data.name}</h1>
                    <p class="text-sm">${data.description}</p>
                </div>
                <div class="mt-4">
                    <a href="view.html?id=${doc.id}" class="btn btn-primary bg-indigo-700 font-bold px-4 py-1 text-white w-auto rounded-md hover:bg-indigo-800">View Tour</a>
                    <a href="edit.html?id=${doc.id}" class="btn btn-primary bg-indigo-700 font-bold px-4 py-1 text-white w-auto rounded-md hover:bg-indigo-800">Edit Tour</a>
                </div>
            </div>`;
            });
        }
     
        $('#logout').on('click', function () {
            auth.signOut().then(() => {
                // Sign-out successful.
              }).catch((error) => {
                // An error happened.
              });
        })