$(document).ready(function(){

    const db = firebase.firestore();
    const auth = firebase.auth();
    const storage =  firebase.storage();
    var sid, uid;
    var selectedPrograms= {};
    var set = [];

    // Firebase Authentication
    auth.onAuthStateChanged(function(user) {
        if(user){
            uid = user.uid
            // Check if School ID is existing
            getSchoolID(user.uid);
            account(user.uid)
            $('.email-nav').text(`${user.email}`);
            
        } else {
            // uid = null;
            window.location.assign("/index.html");
        }
    });
    

    function getSchoolID(uid){
        db.collection('school_admin').doc(uid).onSnapshot( function(snapshot){
            if (snapshot.data().school_id) {
                
                sid = snapshot.data().school_id;
                retrieveData();

                
                db.collection('schools').doc(sid).collection('tuition_fee').orderBy('set', 'asc').onSnapshot(function (snapshot) {
                    $('#tuition-fee-container').html('');
                    snapshot.forEach(function (taskValue) {
                        
                        $('#tuition-fee-container').append(`
                            <div class="col-sm">
                                <p class="font-weight-light">${taskValue.id}:</p>
                                <h5>&#8369;${taskValue.data().from.toLocaleString()} - &#8369;${taskValue.data().to.toLocaleString()} </h5>
                            </div>
                        `);
                        if (taskValue.id == "Bachelors Degree") {
                            $('#bdtf').prop( "checked",true);
                            $('.bdtf').prop('disabled', false);
                            $('#ubdtffrom').val(taskValue.data().from)
                            $('#ubdtfto').val(taskValue.data().to)
                        } else if (taskValue.id == "Masters Degree") {
                            $('#mdtf').prop( "checked",true);
                            $('.mdtf').prop('disabled', false);
                            $('#umdtffrom').val(taskValue.data().from)
                            $('#umdtfto').val(taskValue.data().to)
                        } else if (taskValue.id == "Doctorals Degree") {
                            $('#ddtf').prop( "checked",true);
                            $('.ddtf').prop('disabled', false);
                            $('#uddtffrom').val(taskValue.data().from)
                            $('#uddtfto').val(taskValue.data().to)
                        }
                    })
                }) 
            } else {
                window.location.assign("index.html");
            }
        }); 
    }

    function retrieveData(){
        db.collection('schools').doc(sid).onSnapshot(function (snapshot) {
            var school_info =  snapshot.data();
            // Display
            $('#cover-photo').attr('src',school_info.school_cover_photo);
            $('#display-school-logo').attr('src',school_info.school_logo);
            $('#udisplay-school-logo').attr('src',school_info.school_logo);
            $('#school_name').text(school_info.school_name);
            $('#type').text(school_info.type);
            $('#religious_affiliation').text(school_info.religious_affiliation);
            $('#entrance_exam').text(school_info.entrance_exam);
            $('#term_structure').text(school_info.term_structure);
            $('#start_classes').text(school_info.school_year);
            $('#school_email').text(school_info.email);
            $('#school_website').text(school_info.website);
            $('#school_address').text(school_info.address);

            // Display data on update modal
            $('#uschool_name').val(school_info.school_name);
            $('#utype').val(school_info.type);
            $('#ureligious_affiliation').val(school_info.religious_affiliation);
            $('#uentrance_exam').val(school_info.entrance_exam);
            $('#uterm_structure').val(school_info.term_structure);
            $('#umonth_start').val(school_info.school_year);
            $('#uschool_email').val(school_info.email);
            $('#uschool_website').val(school_info.website);
            $('#uschool_address').val(school_info.address);

            $('#programs-container').html('')
            snapshot.data().programs.forEach(function(value){
                $('#programs-container').append(`
                    <li>
                        <h5>${value}</h5>
                    </li>
                `);
                var idprogram = value.replace(/\s+/g, '');
                $(`#${idprogram}`).prop( "checked",true);
                if (set.indexOf($(`#${idprogram}`).val()) == -1) {
                    set.push($(`#${idprogram}`).val())
                }
            })
            $(`#requirements-container`).html('')
            snapshot.data().requirements.forEach(function(value){
                $(`#requirements-container`).append(`
                <li class="alternate">
                    <h5>${value}</h5>
                </li>
            `);
            var input = $(`[name='req[]'`);
            var rnum = input.length +1;
            
            $('.requirementsContainer').append(`
                <div class="input-group mb-2" id="r${rnum}">
                    <input type="text" value="${value}"  class="form-control" name="req[]" oninput="this.className = 'form-control'" data-bs-toggle="password" required>
                    <button id="${rnum}" class="removereq btn btn-outline-danger" type="button">X</button>
                </div>
            `)
            })

            initMap(school_info.location);
        })
    }

    

    function initMap(location){
        if (location != null ){
            var myLatlng = {lat: location.latitude, lng: location.longitude};
            var mapOptions = {
            zoom: 18,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
    
        marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            draggable: true 
        }); 
    
        google.maps.event.addListener(marker, 'dragend', function() {
            db.collection("schools").doc(sid).update({
                location: new firebase.firestore.GeoPoint(marker.getPosition().lat(),marker.getPosition().lng())
            })
        });
        }
    }

    $('#updateInfoForm').on('submit', function(e){
        e.preventDefault();
        $('#editInfoModal').modal('hide');
        db.collection("schools").doc(sid).update({
            type: $('#utype').val(),
            entrance_exam: $('#uentrance_exam').val(),
            religious_affiliation: $('#ureligious_affiliation').val(),
            term_structure: $('#uterm_structure').val(),
            school_year: $('#umonth_start').val(),
            email: $('#uschool_email').val(),
            website: $('#uschool_website').val(),
            address: $('#uschool_address').val()
            }).then(() => {
            swal({
                title: "Done!",
                text: "School Information Successfully Updated!",
                icon: "success",
                button: "Confirm",
              });
              
        })
    })

    $('#updateTuitionForm').on('submit', function(e){
        e.preventDefault();
        var b = true, m = true, d = true;

        // Bachelors Degree
        // Check if checkbox is checked
        if($('#bdtf').is(':checked')){
            // Check if the range is valid
            if (parseInt($('#ubdtffrom').val()) >= parseInt($('#ubdtfto').val())) { 
                b = false;  
            } else {
                db.collection('schools').doc(sid).collection('tuition_fee').doc('Bachelors Degree').set({
                    set: 1,
                    from: parseInt($('#ubdtffrom').val()),
                    to: parseInt($('#ubdtfto').val())
                })
                db.collection('schools').doc(sid).update({
                           
                    bachelors_cost: parseInt($('#ubdtfto').val())
                })
            }
        } else {
            db.collection('schools').doc(sid).collection('tuition_fee').doc('Bachelors Degree').delete();
            db.collection('schools').doc(sid).update({
                           
                bachelors_cost: 0
            })
        }

        // Masters Degree
        if($('#mdtf').is(':checked')){
            if (parseInt($('#umdtffrom').val()) >= parseInt($('#umdtfto').val())) {
                m = false;
            } else {
                db.collection('schools').doc(sid).collection('tuition_fee').doc('Masters Degree').set({
                    set: 2,
                    from: parseInt($('#umdtffrom').val()),
                    to: parseInt($('#umdtfto').val())
                })
                db.collection('schools').doc(sid).update({
                    masters_cost: parseInt($('#umdtfto').val())
                })
            }
        } else {
            db.collection('schools').doc(sid).collection('tuition_fee').doc('Masters Degree').delete();
            db.collection('schools').doc(sid).update({
                masters_cost: firebase.firestore.FieldValue.delete()
            })
        }

        // Doctorals Degree
        if($('#ddtf').is(':checked')){
            if (parseInt($('#uddtffrom').val()) >= parseInt($('#uddtfto').val())) {
                d = false;
               
            } else { 
                db.collection('schools').doc(sid).collection('tuition_fee').doc('Doctorals Degree').set({
                    set: 3,
                    from: parseInt($('#uddtffrom').val()),
                    to: parseInt($('#uddtfto').val())
                })
                db.collection('schools').doc(sid).update({
                    doctorals_cost: parseInt($('#ddtfto').val())
                })
            }
            
        } else {
            db.collection('schools').doc(sid).collection('tuition_fee').doc('Doctorals Degree').delete();
            db.collection('schools').doc(sid).update({
                doctorals_cost: firebase.firestore.FieldValue.delete()
            })
        }

        if (b&&m&&d) {
            $('#editTuitionModal').modal('hide')
            swal({
                title: "Done!",
                text: "Tuition Fee Successfully Updated!",
                icon: "success",
                button: "Confirm",
            });
        } else {
            alert('Invalid Range')
        }
            
    })
    
    $('#updateProgramsForm').on('submit', function(e){
        e.preventDefault();
               db.collection('schools').doc(sid).update({
                    programs: set
                }).then(()=>{
                    $('#editProgramsModal').modal('hide')
                    swal({
                        title: "Done!",
                        text: "Programs Successfully Updated!",
                        icon: "success",
                        button: "Confirm",
                    });
                })
    })
    $('#updateRequirementsForm').on('submit', function(e){
        e.preventDefault();
        //
        var r = [];
        var input = document.getElementsByName('req[]');
        for (var i = 0; i < input.length; i++) {
            var a = input[i];
            r.push(a.value);
        }
        $('.requirementsContainer').empty()
        db.collection('schools').doc(sid).update({
            requirements: r
        }).then(()=>{
            $('#editRequirementsModal').modal('hide')
            swal({
                title: "Done!",
                text: "Admission Requirements Successfully Updated!",
                icon: "success",
                button: "Confirm",
            });
        })
        //
    })


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
    // End Load Programs Dynamically

    $('#addRequirement').on('click', function() {
        // var input = $("[name='set[]'");
        // var rnum = input.length +1;
            // $("#s"+button_id+"").remove();
            var input = $(`[name='req[]'`);
            var rnum = input.length +1;
            $(`.requirementsContainer`).append(`
                <div class="input-group mb-2" id="r${rnum}">
                    <input type="text" class="form-control" name="req[]" oninput="this.className = 'form-control'" data-bs-toggle="password" required>
                    <button id="${rnum}" class="removereq btn btn-outline-danger" type="button">X</button>
                    
                </div>`)
    });

    // Remove Requirement Dynamically
    $(document).on('click', '.removereq', function(){
        var button_id = $(this).attr("id");
         $(`#r${button_id}`).remove();
        
    });
    // Hover
    $('.school-logo-container').mouseenter(function(){
        $("#choosePhoto").fadeIn(200);
    });
    $('.school-logo-container').mouseleave(function(){
        $("#choosePhoto").fadeOut(200);
    });
    // End Hover


    $('#logout').on('click', function () {
        auth.signOut().then(() => {
            // Sign-out successful.
          }).catch((error) => {
            // An error happened.
          });
    })



    // Hover
    $('.uschool-logo-container').mouseenter(function(){
        $("#uchoosePhoto").fadeIn(200);
    });
    $('.uschool-logo-container').mouseleave(function(){
        $("#uchoosePhoto").fadeOut(200);
    });
    // End Hover


    // Display School Logo
    $('#uschool-logo-input').change(function(){
        const choosedFile = this.files[0];
        if (choosedFile) {
            const reader = new FileReader();
            $(reader).on('load',function(){
                $('#udisplay-school-logo').attr('src', reader.result);
            });
            reader.readAsDataURL(choosedFile);
        }
    });
    // End Display School Logo


    $('#updatePhotoNameForm').on('submit', function(e){
        e.preventDefault();
        $('#editPhotoNameModal').modal('hide')

        var slogo = document.getElementById('uschool-logo-input').files[0];

        
        if (typeof slogo !== 'undefined') {
        var storageRef = storage.ref('school_logos/' + slogo.name);
        var task = storageRef.put(slogo);
        task.on('state_changed',
        (snapshot) => {
                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                console.log('Upload is ' + progress + '% done');	
        },
        (error) => {
            console.log(error);
        },
        () => {
            console.clear();
            // Handle successful uploads on complete
            // For instance, get the download URL: https://firebasestorage.googleapis.com/...
            task.snapshot.ref.getDownloadURL().then((downloadURL) => {
                // Save School Info
                db.collection("schools").doc(sid).update(
                    {
                       
                        school_logo: downloadURL
    
                    }
                )
                
                
            
            });
                
        }
        )
            
        }
        db.collection("schools").doc(sid).update(
            {
                school_name: $('#uschool_name').val()
            }
        ).then(() => {
            swal({
                title: "Done!",
                text: "School Logo And Name Successfully Updated!",
                icon: "success",
                button: "Confirm",
            });
      
        })
        
        
    })

    $('#account').on('click', function(){
       
        $('#accountModal').modal('show');
       
    })

    function account(uid){
        db.collection('school_admin').doc(uid).onSnapshot(function(snapshot){
            $('#name').val(snapshot.data().name)
            $('#email').val(snapshot.data().email)
        })
    }

    $('#updateAccount').on('submit', function(e){
        e.preventDefault();
        auth.signInWithEmailAndPassword(auth.currentUser.email, $('#password').val()).then( function(userCredential){
            userCredential.user.updateEmail($('#email').val())
            db.collection("school_admin").doc(uid).update({
                name: $('#name').val(),
                email: $('#email').val()
            })
            $('#accountModal').modal('hide');
            $('#password').val('')
        })
    })
})