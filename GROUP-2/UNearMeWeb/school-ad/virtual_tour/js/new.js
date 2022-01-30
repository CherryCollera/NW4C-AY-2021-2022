const db = firebase.firestore();
const auth = firebase.auth();

// Firebase Authentication
auth.onAuthStateChanged(function(user) {
    if(user){
        // Check if School ID is existing
        getSchoolID(user.uid);
        
    } else {
        // uid = null;
    }
});
function getSchoolID(uid){
    db.collection('school_admin').doc(uid).onSnapshot( function(snapshot){
        if (snapshot.data().school_id) {
            
            sid = snapshot.data().school_id;
            db.collection('schools').doc(sid).onSnapshot(function (snapshot) {
                if(snapshot.data().tour_id){
                    window.location.assign("dashboard.html");
                }
                 
                
             }) 
        } else {
            window.location.assign("/index.html");
        }
    }); 
}

let total,
        processed = 0;

    function updateLoading() {
        const progressText = document.querySelector("span[data-info-id='progressText']"),
            progressBar = document.querySelector("div[data-info-id='progressBar']"),
            progressFiles = document.querySelector("span[data-info-id='progressFiles']"),
            percentage = ((processed / total) * 100).toFixed(2);

        progressText.innerHTML = `${percentage}%`;
        progressBar.style.width = `${percentage}%`;
        progressFiles.innerHTML = `${processed} of ${total} remaining`;
    }

    async function createTour() {
        let tourName = document.querySelector("input[name='tourName']"),
            tourDescription = document.querySelector("textarea[name='tourDescription']"),
            tourPictures = document.querySelector("#file-upload"),
            createTourBtn = document.querySelector("#createTour"),
            progress = document.querySelector("div[data-container-id='progress']");

        total = tourPictures.files.length;
        progress.style.display = "block";

        createTourBtn.setAttribute("class", "bg-gray-500 text-white py-1 px-4 rounded-md cursor-not-allowed opacity-50");
        createTourBtn.setAttribute("disabled", "disabled");

        updateLoading();

        const formdata = new FormData();

        let images = [],
            compress_images_queue = [],
            img_urls = [];

        for (let file of tourPictures.files) {
            compress_images_queue.push(new Promise((resolve, reject) => {
                new Compressor(file, {
                    quality: 0.1,

                    // The compression process is asynchronous,
                    // which means you have to access the `result` in the `success` hook function.
                    success: resolve,
                    error: reject
                });
            }));
        }

        let compressed_images = await Promise.all(compress_images_queue).then((data) => data).catch(e => console.log(e));

        for (let image of compressed_images) {
            formdata.append("image", image);

            images.push(fetch("https://api.imgur.com/3/image/", {
                method: "post",
                headers: {
                    Authorization: "Client-ID b1b0860344d25f5"
                },
                body: formdata
            }).then((data) => data.json()).then((data) => {
                processed++;
                updateLoading();
                return data.data.link
            }));
        }

        img_urls = await Promise.all(images).then((data) => data).catch(e => console.log(e));

        console.log(img_urls);
        db.collection("tours").add({
            name: tourName.value,
            description: tourDescription.value,
            pictures: img_urls,
            scenes: JSON.stringify({
                1: {
                    "hfov": 110,
                    "pitch": 0,
                    "yaw": 0,
                    "type": "equirectangular",
                    "panorama": img_urls[0],
                    "hotSpots": []
                }
            })
        }).then(async(docRef) => {
            await db.collection("schools").doc(sid).update({
                tour_id: docRef.id
            })
            //window.location.href = "dashboard.html";

        })
        .catch((error) => {
            console.error("Error adding document: ", error);
        });
    }
 
    