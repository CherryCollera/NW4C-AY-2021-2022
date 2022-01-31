import Navbar from '../components/Navbar'
import PetsDiv from '../components/PetsDiv'
import React, { useEffect, useState } from 'react'
import ANavBar from '../Admin/components/ANavBar'
import { getDoc } from '../Functions/Functions'
import firebase, { auth } from '../config/firebase'
function Pets() {
    const [cur, setcur] = useState([]);
    const [pet1, setpet1] = useState('');
    const [user, setuser] = useState(false);
    useEffect(() => {
        auth.onAuthStateChanged(user => {
            if (user) {
                setuser(user.uid);
                getDoc(firebase, user.uid).then(data => {
                    setcur(data);
                })
            } else {
                setuser(false);
            }
        })
    }, [pet1.PetId])
    return (
        <div>
            {cur && cur.type === 'admin'
                ? <ANavBar back={true} backto={`/profile/${pet1.owner}`} admin={true} />
                : <Navbar sd={user ? 'dash' : 'guest'} />}
            <PetsDiv user={user} pet1={(e) => { setpet1(e) }} />
        </div>
    )
}

export default Pets
