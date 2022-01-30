var uid = null;
var sid = null;
var isChanged = null;
var r = 1;
// firebase.auth().onAuthStateChanged(function(user) {
//     // if admin is loggedIn 
//     if(user){
//         uid = user.uid;
//         getSchoolID(uid);
//     } else {
//         uid = null;
//         window.location.assign("index.html");
//     }
// });

// Fields
var type = document.querySelector('#type');
var entrance_exam = document.querySelector('#entrance_exam');
var religious_affiliation = document.querySelector('#religious_affiliation');
var term_structure = document.querySelector('#term_structure');
var bachelors_cost = document.querySelector('#bachelors_cost');
var masters_cost = document.querySelector('#masters_cost');
var month_start = document.querySelector('#month_start');
var school_email = document.querySelector('#school_email');
var school_website = document.querySelector('#school_website');
var school_address = document.querySelector('#school_address');
var school_name = document.querySelector('#school_name');



// Get School ID
function getSchoolID(uid){
    db.collection('school_admins').doc(uid).get().then((snapshot)=>{
        sid = snapshot.data().school_id;
        getSchoolInfo(sid);
    }); 
}
// Get School Info
function getSchoolInfo(school_id){
    db.collection('schools').doc(school_id).get().then((snapshot)=>{
        // Displaying Data
        type.value = snapshot.data().type;
        entrance_exam.value = snapshot.data().entrance_exam;
        religious_affiliation.value = snapshot.data().religious_affiliation;
        term_structure.value = snapshot.data().term_structure;
        bachelors_cost.value = snapshot.data().bachelors_cost;
        masters_cost.value = snapshot.data().masters_cost;
        month_start.value = snapshot.data().school_year;
        school_email.value = snapshot.data().email;
        school_website.value = snapshot.data().website;
        school_address.value = snapshot.data().address;
        school_name.innerHTML = snapshot.data().school_name;

        document.getElementById('school_logo').src = snapshot.data().school_logo;

        snapshot.data().requirements.forEach(element => {
            
            $('#req').append(`<div class="d-flex" id="r${r}"><input type="text" class="form-control mt-3"  name="req[]" required value="${element}"><button id="${r}" class="removereq btn">X</button></div>`)
            r++;
        });
        
        snapshot.data().programs.forEach(element => {
            
            $('#prog').append(`<div class="d-flex" id="r${r}"><input type="text" class="form-control mt-3" name="prog[]" required value="${element}"><button id="${r}" class="removereq btn">X</button></div>`)
            r++;
        });
    
        
        var addlat = snapshot.data().location.latitude;
        var lng = snapshot.data().location.longitude;

        initMap(addlat, lng);

    }); 
    
}


const buttonsInfo = document.querySelector('#buttons-info');
const fieldSetInfo = document.querySelector('#fieldset-info');
const editInfobtn = document.querySelector('#edit-info');

const buttonsReq = document.querySelector('#buttons-req');
const fieldSetReq = document.querySelector('#fieldset-req');
const editReqbtn = document.querySelector('#edit-req');

const buttonsProg = document.querySelector('#buttons-prog');
const fieldSetProg = document.querySelector('#fieldset-prog');
const editProgbtn = document.querySelector('#edit-prog');

function saveInfo(){
    if (isChanged === "changed"){
        isChanged = "done"
        db.collection("schools").doc(sid).update({
            type: type.value,
            entrance_exam: entrance_exam.value,
            religious_affiliation: religious_affiliation.value,
            term_structure: term_structure.value,
            bachelors_cost: parseInt(bachelors_cost.value),
            masters_cost: parseInt(masters_cost.value),
            school_year: month_start.value,
            email: school_email.value,
            website: school_website.value,
            address: school_address.value
        }).then(() => {
            fieldSetInfo.setAttribute('disabled','');
            editInfobtn.style.display = "block";
            buttonsInfo.style.display = "none";
            swal({
                title: "Done!",
                text: "Info successfully updated!",
                icon: "success",
                button: "Okay",
              });
        })
    } else {
        fieldSetInfo.setAttribute('disabled','');
            editInfobtn.style.display = "block";
            buttonsInfo.style.display = "none";
    }
    
}


function saveReq(){
    var r = [];

    var input = document.getElementsByName('req[]');

    for (var i = 0; i < input.length; i++) {
        var a = input[i];
        r.push(a.value);
    }

    // if (isChanged === "changed"){
    //     isChanged = "done"
        db.collection("schools").doc(sid).update({
            requirements: r
        }).then(() => {
            fieldSetReq.setAttribute('disabled','');
            editReqbtn.style.display = "block";
            buttonsReq.style.display = "none";
            swal({
                title: "Done!",
                text: "Requirements successfully updated!",
                icon: "success",
                button: "Okay",
              });
        })
    // } else {
    //     fieldSetInfo.setAttribute('disabled','');
    //         editReqbtn.style.display = "block";
    //         buttonsReq.style.display = "none";
    // }

}
function saveProg(){
    var p = [];

    var input = document.getElementsByName('prog[]');

    for (var i = 0; i < input.length; i++) {
        var a = input[i];
        p.push(a.value);
    }

    // if (isChanged === "changed"){
    //     isChanged = "done"
        db.collection("schools").doc(sid).update({
            programs:p
        }).then(() => {
            fieldSetProg.setAttribute('disabled','');
            editProgbtn.style.display = "block";
            buttonsProg.style.display = "none";
            swal({
                title: "Done!",
                text: "Requirements successfully updated!",
                icon: "success",
                button: "Okay",
              });
        })
    // } else {
    //     fieldSetInfo.setAttribute('disabled','');
    //         editReqbtn.style.display = "block";
    //         buttonsReq.style.display = "none";
    // }

}
// Button Click Edit Info
function editInfo(){
    fieldSetInfo.removeAttribute('disabled');
    editInfobtn.style.display = "none";
    buttonsInfo.style.display = "block";
}

function cancelInfo(){
    fieldSetInfo.setAttribute('disabled','');
    editInfobtn.style.display = "block";
    buttonsInfo.style.display = "none";
}

var form = document.querySelector("#fieldset-info");
form.addEventListener("input", function () {
    isChanged = "changed";
});

// Button Click Edit Req
function editReq(){
    fieldSetReq.removeAttribute('disabled');
    editReqbtn.style.display = "none";
    buttonsReq.style.display = "block";
}

function cancelReq(){
    fieldSetReq.setAttribute('disabled','');
    editReqbtn.style.display = "block";
    buttonsReq.style.display = "none";
}

function addReq(){
    var input = document.getElementsByName('req[]');
    console.log(input);
    var rnum = input.length +1;
    $('#req').append(`  <div class="d-flex" id="r${rnum}">
                            <input type="text" class="form-control mt-3"  name="req[]" required>
                            <button id="${rnum}" class="removereq btn">X</button>
                        </div>`)
    rnum++
    console.log(rnum);
}

$(document).on('click', '.removereq', function(){
    var button_id = $(this).attr("id");
    $("#r"+button_id+"").remove();

});

// Button Click Edit Prog
function editProg(){
    fieldSetProg.removeAttribute('disabled');
    editProgbtn.style.display = "none";
    buttonsProg.style.display = "block";
}

function cancelProg(){
    fieldSetProg.setAttribute('disabled','');
    editProgbtn.style.display = "block";
    buttonsProg.style.display = "none";
}

function addProg(){
    var input = document.getElementsByName('prog[]');
    var rnum = input.length +1;
    $('#prog').append(`  <div class="d-flex" id="p${rnum}">
                            <input type="text" class="form-control mt-3"  name="prog[]" required>
                            <button id="${rnum}" class="removeprog btn">X</button>
                        </div>`)
    rnum++
    console.log(rnum);
}

$(document).on('click', '.removeprog', function(){
    var button_id = $(this).attr("id");
    $("#p"+button_id+"").remove();

});

var form = document.querySelector("#fieldset-info");
form.addEventListener("input", function () {
    isChanged = "changed";
});
var form = document.querySelector("#fieldset-req");
form.addEventListener("input", function () {
    isChanged = "changed";
});

const logout = document.querySelector('#logout');
// Click logount
logout.addEventListener('click', (e) => {
    firebase.auth().signOut();
});


var map;
var marker;
var school_lat;
var school_lng;
function initMap(lattt, longgg){
    
    
    if (lattt != null && longgg != null){
        $('#update-address').val(school_address.value);
        var myLatlng = {lat: lattt, lng: longgg};
        var mapOptions = {
        zoom: 8,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("myMap"), mapOptions);

    marker = new google.maps.Marker({
        map: map,
        position: myLatlng,
        draggable: true 
    }); 

    google.maps.event.addListener(marker, 'dragend', function() {
        school_lat = marker.getPosition().lat();
        school_lng = marker.getPosition().lng();
    });
    }
    

}


// address form
const addressForm = document.querySelector('#address-form')
// login onClick
addressForm.addEventListener('submit', (e) =>{
  e.preventDefault();

  // Get user info
  const address = addressForm['update-address'].value;
  
  db.collection("schools").doc(sid).update({
    address: address,
    location: new firebase.firestore.GeoPoint(school_lat,school_lng)
    }).then(() => {
    swal({
        title: "Done!",
        text: "Address successfully updated!",
        icon: "success",
        button: "Okay",
      });
      getSchoolInfo(sid);
})
  
});

