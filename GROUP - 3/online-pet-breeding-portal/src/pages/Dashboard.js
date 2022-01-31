import AddPost from '../components/AddPost'
import Navbar from '../components/Navbar'
import { getDoc } from '../Functions/Functions'
import Post from '../components/Post'
import '../components/DashboardHome.css'
import firebase, { auth } from '../config/firebase'

import React, { useEffect, useState } from 'react'
import BreedDash from '../components/BreedDash'

function Dashboard() {
    const [userData, setuserData] = useState([]);
    const [post, setPost] = useState([]);
    const [user, setuser] = useState(false);


    const getPost = () => {
        firebase.collection("Post").where('deleted', '==', false).orderBy('timestamp', 'desc').onSnapshot((snaps) => {
            setPost(snaps.docs.map(doc => doc.data()))
        }
        )
    }


    useEffect(() => {
        const interval = setInterval(() => {
            auth.onAuthStateChanged(user => {
                getPost();
                if (user) {
                    setuser(user.uid);
                    getDoc(firebase, user.uid).then(data => {
                        setuserData(data);
                    })
                } else {
                    setuser(false);
                }
            })
        });
        return () => clearInterval(interval);
    }, [])


    return (
        <div className='ohayo'>
            <Navbar sd={user ? 'dash' : 'guest'} hd='Home' />
            <div className={user ? 'leftD' : 'leftD gyest'}>
                {user && userData && <AddPost UD={userData} />}
                {post ? <Post user={user} post={post} /> : <div className="NoPost">No post available</div>}
            </div>
            {user && <div className='rightD'>
                <BreedDash />
            </div>}
        </div>
    )
}

export default Dashboard
