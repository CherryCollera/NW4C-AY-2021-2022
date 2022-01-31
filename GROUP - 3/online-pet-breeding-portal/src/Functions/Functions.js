import firebase, { auth } from "../config/firebase";
import emailjs, { init } from 'emailjs-com';
init("user_pg7ykA66Gvmnw6z7T6WLV");

export const createuser = (a, b, c, d, e, f, g, h, j, k, l, m, n) => {
    // console.log(a, b, c, d, e, f, g, h, j, k, l, m, n)

    var conf = true;
    var tempID = 'template_j12g698';
    var templateParams = {
        user: a,
        reciever: f,
    };

    if (m === 'veterinarian') {
        conf = false;
        tempID = 'template_zpxebba';
    }
    emailjs.send('service_sb65ext', tempID, templateParams)
        .then(function (response) {
            auth.createUserWithEmailAndPassword(f, h).then(user => {
                if (!user) return;
                user.user.updateProfile({
                    displayName: a + ' ' + b + ' ' + c,
                }).then(user => {
                    const uids = auth.currentUser.uid;
                    const userRef = firebase.doc(`users/${uids}`);
                    const snaps = userRef.get();
                    if (!snaps.exist) {
                        try {
                            userRef.set({
                                uid: uids,
                                first_name: a,
                                middle_name: b,
                                last_name: c,
                                birthday: new Date(d),
                                gender: e,
                                email: f,
                                contact: g,
                                isOnline: new Date(),
                                password: h,
                                location: {
                                    lat: j,
                                    lng: k,
                                    address: l,
                                    timestamp: new Date(),
                                },
                                address: l,
                                type: m,
                                bgColor: n,
                                banned: false,
                                confirmed: conf,
                                timestamp: new Date()
                            })
                            return true;
                        } catch (error) {
                            window.location.href = '/'
                            console.log("Error in creating user info", error);
                        }
                    } else {
                        console.log("Error in creating user info, user Exist");
                        window.location.href = '/'
                    }
                }
                ).finally(
                    auth.signInWithEmailAndPassword(
                        f, h
                    )
                )
            }).catch(err => {
                console.log("Error in creating user info", err);
            });

        }, function (error) {
            console.log('FAILED...', error);
        });


}

export const createPet = (a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, close) => {
    // console.log("Pet creation Started");
    const uids = auth.currentUser.uid;
    const petRef = firebase.collection("Pets");
    try {
        petRef.add({
            bdate: new Date(a).toLocaleDateString(),
            name: b,
            gender: c,
            species: d,
            owner: uids,
            breed: e,
            breeding: false,
            furColor: f,
            eyeColor: g,
            desc: h,
            bgColor: i,
            antirabbies: {
                type: "Anti Rabbies",
                doc: j,
                confirmed: false,
                timestamp: new Date(),
            },
            deworming: {
                type: "Deworming",
                doc: k,
                confirmed: false,
                timestamp: new Date(),
            },
            vaccine: {
                type: l,
                doc: m,
                confirmed: false,
                timestamp: new Date(),
            },
            checkup: {
                type: "Check Ups",
                doc: n,
                confirmed: false,
                timestamp: new Date(),
            },
            vitamins: {
                type: "Vitamins",
                doc: o,
                confirmed: false,
                timestamp: new Date(),
            },
            timestamp: new Date()

        }).then(pet => {
            firebase.doc("Pets/" + pet.id).set({ PetId: pet.id, }, { merge: true })
                .finally(d => {
                    close.then(data => {
                        if (data) {
                            firebase.collection("Pets").where("owner", "==", auth.currentUser.uid).limit(1).onSnapshot(pets => {
                                if (pets.empty) {
                                    window.location.href = `/pets`
                                } else {
                                    window.location.href = `/pets/${pets.docs[0].data().PetId}`
                                }
                            })
                        }
                    })

                });

        })
    } catch (error) {
        console.log("Error in creating pet info", error);
    };
}

export const userWall = (id) => {
    firebase.doc(`users/${id}`).onSnapshot(snap => {
        if (snap.data().type === 'admin') {
            window.location.href = '/admin';
        } else if (snap.data().type === 'pet-breeder') {
            window.location.href = '/dashboard';
        }
    })
}
export const getDoc = async (db, id) => {
    const ref = db.doc(`users/${id}`);
    const doc = await ref.get();
    try {
        if (doc.exists) {
            return doc.data();
        }
    } catch (error) {
        console.error(error)
    }
}

export const getPets = async (db, id) => {
    const PetRef = db.collection("Pets");
    const petList = await PetRef.where('owner', '==', id).get();
    return (petList.docs.map(doc => doc.data()));
}

export const randomColor = () => {
    var randomC = Math.floor(Math.random() * 16777215).toString(16);
    if (randomC.length <= 5) {
        randomC += "5"
    }
    return "#" + randomC;
}

export const getMes = async (db, id) => {
    const mesRef = db.collection(`Messages`).where("convos", '>', 0).orderBy("convos", "desc").where("p1", "==", id).orderBy("timestamp", "desc");
    const doc = await mesRef.get();
    try {
        if (!doc.empty) {
            return (doc.docs.map(doc => doc.data()))
        } else {
            return 'noMessage';
        }
    } catch (error) {
        console.error(error)
    }
}
export const getMes2 = async (db, id) => {
    const mes2Ref = db.collection(`Messages`).where("convos", '>', 0).orderBy("convos", "desc").where("p2", "==", id).orderBy("timestamp", "desc");
    const doc = await mes2Ref.get();
    try {
        if (!doc.empty) {
            return (doc.docs.map(doc => doc.data()))
        } else {
            return 'noMessage';
        }
    } catch (error) {
        console.error(error)
    }
}
export const getConvos = async (db, asd) => {
    const sda = await db.collection(`Messages/${asd}/convo`).orderBy("timestamp", "desc").get();
    try {
        if (!sda.empty) {
            return (sda.docs.map(doc => doc.data()))
        } else {
            return 'noMessage';
        }
    } catch (error) {
        console.error(error)
    }
}

export const checkCon = async () => {
    try {
        const online = await fetch("/1pixel.png");
        return online.status >= 200 && online.status < 300;
    } catch (err) {
        return false;
    }
}

export const offLineUser = {
    uid: '112312e1e12312',
    first_name: 'Rolando',
    middle_name: 'Lazo',
    last_name: 'Ahito',
    birthday: 'December 06, 1998',
    gender: 'Male',
    email: 'rolandoallanofficial@gmail.com',
    contact: '0912-761-5685',
    password: 'pass123',
    city: 'Balanga',
    baranggay: 'Bagong Silang',
    address: 'Tiangco St. Roguza comp.',
    type: 'Pet Breeder',
    bgColor: '#513f12',
    confirmed: true,
    timestamp: new Date(),
};

export const offLinePet = [{
    bdate: new Date().toLocaleDateString(),
    name: 'Bruno',
    gender: 'Male',
    species: 'Dog',
    owner: '112312e1e12312',
    breed: 'Poodle',
    furColor: 'Brown',
    eyeColor: 'Brown',
    desc: 'Macute',
    bgColor: randomColor(),
    timestamp: new Date()
},
{
    bdate: new Date().toLocaleDateString(),
    name: 'Diego',
    gender: 'Female',
    species: 'Cat',
    owner: '112312e1e12312',
    breed: 'Asian',
    furColor: 'Orange',
    eyeColor: 'red',
    bgColor: randomColor(),
    desc: 'Macute',
    timestamp: new Date()
},
];

export const MessageInbox = [
    { ID: 'ddw2das23', timestamp: new Date(), user1: '112312e1e12312', user2: 'da2dawe2esc' },
    { ID: 'asdasdasdd', timestamp: new Date(), user1: '112312e1e12312', user2: 'asdasdasdda' },
    { ID: 'asdsdsada', timestamp: new Date(), user1: '112312e1e12312', user2: 'asdsdasada' },
    { ID: 'ascacasdas', timestamp: new Date(), user1: '112312e1e12312', user2: 'ascacasadas' },
    { ID: 'asdwqc1asd', timestamp: new Date(), user1: '112312e1e12312', user2: 'asdwqc1asd21' },
    { ID: '23432dassa', timestamp: new Date(), user1: '112312e1e12312', user2: '23432dassa4' },
    { ID: 'we234rey6', timestamp: new Date(), user1: '112312e1e12312', user2: 'we234rey624sa' },
    { ID: '2eewr2324', timestamp: new Date(), user1: '112312e1e12312', user2: '2eewr23242a' },
]

    // handleText(a) {
    //     this.setState({
    //         text:
    //             a.replace(/(^\w|\s\w)/g, m => m.toUpperCase()),
    //     });
    // }