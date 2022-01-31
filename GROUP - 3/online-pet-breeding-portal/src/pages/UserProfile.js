
import React, { useEffect, useState } from 'react'
import Navbar from '../components/Navbar'
import ANavBar from '../Admin/components/ANavBar'
import UserProfiles from '../components/UserProfiles'
import { getDoc } from '../Functions/Functions'
import firebase, { auth } from '../config/firebase'

function UserProfile() {
    const [userData, setuserData] = useState([]);
    const [cur, setcur] = useState([]);
    const [userID, setuserID] = useState('');
    const [user, setuser] = useState(false);
    useEffect(() => {
        auth.onAuthStateChanged(user => {
            if (user) {
                setuser(user.uid);
                getDoc(firebase, user.uid).then(data => {
                    setcur(data);
                })
                const path = window.location.pathname;
                if (!(path.length <= 9)) {
                    getDoc(firebase, path.substring(9, path.length)).then(data => {
                        setuserData(data);
                        setuserID(path.substring(9, path.length));
                    })
                } else {
                    getDoc(firebase, user.uid).then(data => {
                        setuserData(data);
                        setuserID(user.uid);
                    })
                }
            } else {
                const path = window.location.pathname;
                getDoc(firebase, path.substring(9, path.length)).then(data => {
                    setuserData(data);
                })
                setuser(false);
                setuserID(path.substring(9, path.length));
            }
        })
    }, [])

    return (
        <>
            {cur && cur.type === 'admin'
                ? <ANavBar back={true} backto='/admin' admin={true} />
                : <Navbar sd={user ? 'dash' : 'guest'} jd='Profile' />}
            <UserProfiles userID={userID} user={user} UD={userData} />
        </>
    )
}

export default UserProfile
