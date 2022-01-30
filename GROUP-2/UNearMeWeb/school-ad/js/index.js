$(document).ready(function(){
    $(".loader").hide();


    // Global Variables
    const db = firebase.firestore();
    const auth = firebase.auth();
    const storage =  firebase.storage();
    var school_name, province;
    var uid;
    var set = [];
    var r = [];
    var selectedPrograms= {};
    var s = {};
    var lat, lng;
    
    // Firebase Authentication
    auth.onAuthStateChanged(function(user) {
        if(user){
            $('.email-nav').text(`${user.email}`);
            if (user.emailVerified) {
                uid = user.uid;
                checkSchool();
            } else {
                window.location.assign("verify-email.html");
            }
            
        } else {
            uid = null;
            window.location.assign("/index.html");
        }
       
    });
    // End Firebase Authentication

    // Check if School is existing
    function checkSchool() {
        db.collection('school_admin').doc(uid).get().then((snapshot)=>{
            if (snapshot.data().school_id) {
                window.location.assign("home.html");
            } else {
                if (snapshot.data().status == 'pending') {
                    $("#myModal").modal('show');
                } else {
                    $("#myModal").modal('hide');
                    school_name = snapshot.data().school_name;
                    province = snapshot.data().province;
                    $('#school-name-holder').html(school_name);

                    // initMap(14.671500024914689, 120.46063728508949);
                    if (snapshot.data().province == 'Bataan') {
                        initMap(14.671500024914689, 120.46063728508949)
                    } else if (snapshot.data().province == 'Aurora') {
                        initMap(15.961925808456, 121.5844584559103)
                    } else if (snapshot.data().province == 'Bulacan') {
                        initMap(14.77108377623267, 120.87160715951265)
                    } else if (snapshot.data().province == 'Nueva Ecija') {
                        initMap(15.601217328717107, 121.04024762297954)
                    } else if (snapshot.data().province == 'Pampanga') {
                        initMap(15.070205752745109, 120.66368708466874)
                    } else if (snapshot.data().province == 'Tarlac') {
                        initMap(15.478767757442405, 120.48143362376292)
                    } else if (snapshot.data().province == 'Zambales') {
                        initMap(15.273126941029147, 120.18255744253752)
                    }
                }
                
            }
        }); 
    }
    // End Check if School is existing

    $('#mapDone').on('click', function(){


        if (typeof lat === 'undefined' && typeof lng === 'undefined') {
            alert('Please move the marker to the exact location.')
        } else{
            $('#mapModal').modal('hide');
        }
    })
    // Saving Data
    $('#regForm').on('submit', function(e){
        e.preventDefault();
        $(".loader").fadeIn();
        $(".content").hide();

        var input = document.getElementsByName('req[]');
        for (var i = 0; i < input.length; i++) {
            var a = input[i];
            r.push(a.value);
        }

        
        var slogo = document.getElementById('school-logo-input').files[0];
        var storageRef = storage.ref('school_logos/' + slogo.name);
        var task = storageRef.put(slogo);
        task.on('state_changed', (snapshot) =>{
            var progress = (snapshot.bytesTransferred/snapshot.totalBytes) * 100;
            console.log(progress);
        },(error)=>{

        },
        async () => {
            // Handle successful uploads on complete
            // For instance, get the download URL: https://firebasestorage.googleapis.com/...
            const photoUrl = await  task.snapshot.ref.getDownloadURL();
                // Save School Info
            const doc = await db.collection("schools").add(
                {
                    date_added: firebase.firestore.FieldValue.serverTimestamp(),
                    school_name: school_name,
                    school_logo: photoUrl,
                    type: $('#type').val(),
                    entrance_exam: $('#entrance_exam').val(),
                    religious_affiliation: $('#religious_affiliation').val(),
                    term_structure: $('#term_structure').val(),
                    school_year: $('#month_start').val(),
                    email: $('#school_email').val(),
                    website: $('#school_website').val(),
                    address: $('#school_address').val(),
                    province: province,
                    location: new firebase.firestore.GeoPoint(lat,lng),
                    programs: set,
                    requirements: r

                }
            )

            db.collection('school_admin').doc(uid).update({
                school_id: doc.id
            })
            db.collection('schools').doc(doc.id).update({
                school_id: doc.id
            })

            if($('#bdtf').is(':checked')){
                db.collection('schools').doc(doc.id).collection('tuition_fee').doc('Bachelors Degree').set({
                    set: 1,
                    from: parseInt($('#bdtffrom').val()),
                    to: parseInt($('#bdtfto').val())
                })
                db.collection('schools').doc(doc.id).update({
                    
                    bachelors_cost: parseInt($('#bdtfto').val())
                })
            } else {
                db.collection('schools').doc(doc.id).update({
                    
                    bachelors_cost: 0
                })
            }
            if($('#mdtf').is(':checked')){
                db.collection('schools').doc(doc.id).collection('tuition_fee').doc('Masters Degree').set({
                    set: 2,
                    from: parseInt($('#mdtffrom').val()),
                    to: parseInt($('#mdtfto').val())
                })
                db.collection('schools').doc(doc.id).update({
                    masters_cost: parseInt($('#mdtfto').val())
                })
            }
            if($('#ddtf').is(':checked')){
                db.collection('schools').doc(doc.id).collection('tuition_fee').doc('Doctorals Degree').set({
                    set: 3,
                    from: parseInt($('#ddtffrom').val()),
                    to: parseInt($('#ddtfto').val())
                })
                db.collection('schools').doc(doc.id).update({
                    doctorals_cost: parseInt($('#ddtfto').val())
                })
            }
            
            checkSchool();
                
        }
        )
        
        
        
    });

  
    // Load Programs Dynamically
    $.each(programs, function(index, value){
        var trimmedValue = value.replace(/\s+/g, '');
        var checkbox=
            `<div class="form-check mb-1">
                <input class="form-check-input" type="checkbox" name="checkbox" value="${value}" id="${trimmedValue}">
                <label class="form-check-label" for="${trimmedValue}">${value}</label>
            </div>`
        $(".checkBoxContainer").append(checkbox); 

        var checked = document.querySelectorAll(`input[id=${trimmedValue}]`);
            checked.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if ($(this).is(':checked')) {
                        set.push(value)
                    } else {
                        set.splice(set.indexOf(`${value}`),1)
                    }
                    
                
                })
            });
        
    })
    // $.each(programs,function(set,results){
    //     var trimmedSet = set.replace(/\s+/g, '');
    //     var title = "<div class='mb-3' id='"+trimmedSet+"'><h4>"+set+"</h4></div>"
    //     $(".checkBoxContainer").append(title);
       
    //     var setTitle = set;
    //     set = [];
        
    //     $.each(results, function(key, value){

    //         var trimmedValue = value.replace(/\s+/g, '');
    //         var checkbox=
    //             `<div class="form-check mb-1">
    //                 <input class="form-check-input" type="checkbox" name="checkbox" value="${value}" id="${trimmedValue}">
    //                 <label class="form-check-label" for="${trimmedValue}">${value}</label>
    //             </div>`
    //         $("#"+trimmedSet).append(checkbox);  

    //         var test = document.querySelectorAll(`input[id=${trimmedValue}]`);
    //         test.forEach(function(checkbox) {
    //             checkbox.addEventListener('change', function() {
    //                 if ($(this).is(':checked')) {
    //                     set.push(value)
    //                 } else {
    //                     set.splice(set.indexOf(`${value}`),1)
    //                 }
                    
                
    //             })
    //         });
    //     })  
    //     selectedPrograms[setTitle] = set;
    // })
    // End Load Programs Dynamically

    // Add Requirement Dynamically
    $('#addRequirement').on('click', function() {
        // var input = $("[name='set[]'");
        // var rnum = input.length +1;
            // $("#s"+button_id+"").remove();
            var input = $(`[name='req[]'`);
            var rnum = input.length +1;
            $(`.requirementsContainer`).append(`
                <div class="input-group mb-2" id="r${rnum}">
                    <input type="text" class="form-control" name="req[]" oninput="this.className = 'form-control'" data-bs-toggle="password">
                    
                        <button id="${rnum}" class="removereq btn btn-outline-danger" type="button">X</button>
                    
                </div>`)
    });
    // End Add Requirement Dynamically


    // Remove Requirement Dynamically
    $(document).on('click', '.removereq', function(){
        var button_id = $(this).attr("id");
         $(`#r${button_id}`).remove();

    });
    

    // Enable/Disable tuition fee fields
    $('#bdtf').on('change', function(){
        if ($(this).is(':checked')) {
            $('.bdtf').prop('disabled', false);
            $('.bdtf').val("");
        } else {
            $('.bdtf').prop('disabled', true);
            $('.bdtf').val("0");
        }
    });
    $('#mdtf').on('change', function(){
        if ($(this).is(':checked')) {
            $('.mdtf').prop('disabled', false);
            $('.mdtf').val("");
        } else {
            $('.mdtf').prop('disabled', true);
            $('.mdtf').val("0");
        }
    });
    $('#ddtf').on('change', function(){
        if ($(this).is(':checked')) {
            $('.ddtf').prop('disabled', false);
            $('.ddtf').val("");
        } else {
            $('.ddtf').prop('disabled', true);
            $('.ddtf').val("0");
        }
    });
    //End Enable/Disable tuition fee fields

    
    // Hover
    $('.school-logo-container').mouseenter(function(){
        $("#choosePhoto").fadeIn(200);
    });
    $('.school-logo-container').mouseleave(function(){
        $("#choosePhoto").fadeOut(200);
    });
    // End Hover


    // Display School Logo
    $('#school-logo-input').change(function(){
        const choosedFile = this.files[0];
        if (choosedFile) {
            const reader = new FileReader();
            $(reader).on('load',function(){
                $('#display-school-logo').attr('src', reader.result);
            });
            reader.readAsDataURL(choosedFile);
        }
    });
    // End Display School Logo

// MAP
function initMap(lt,lg) {
    // Initialize Map
    var mapLatlng =  {lat: lt, lng: lg};
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: mapLatlng,
        marker
    });
    // Map Marker
    var marker = new google.maps.Marker({
        map: map,
        position: mapLatlng,
        draggable: true 
    });
    // Drag Marker
    google.maps.event.addListener(marker, 'dragend', function() {
        lat = marker.getPosition().lat();
        lng = marker.getPosition().lng();
    });
}


$('#logout').on('click', function () {
    auth.signOut().then(() => {
        // Sign-out successful.
      }).catch((error) => {
        // An error happened.
      });
})


    
})
// End MAP

function URLChange(titlestr) {
    document.getElementsByName("url_code")[0].value=titlestr;
    document.getElementById("school_address").classList.add('form-control')
    document.getElementById("school_address").classList.remove('invalid')
}