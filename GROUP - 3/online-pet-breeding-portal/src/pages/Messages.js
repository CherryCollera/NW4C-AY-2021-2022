import MessagesDiv from '../components/MessagesDiv'
import Navbar from '../components/Navbar'

import React, { useEffect, useState } from 'react'
import { useLocation } from 'react-router-dom';

function Messages() {
    const [userData, setuserData] = useState([]);
    const [fromUserID, setfromUserID] = useState([]);
    const [hideDrop, sethideDrop] = useState([]);
    const location = useLocation();
    useEffect(() => {
        if (location.state !== undefined) {
            const { fromUserID, hideDrop } = location.state;
            setfromUserID(fromUserID);
            sethideDrop(hideDrop);
        } else {
            setuserData('');
        }

    }, [userData, location.state])
    return (
        <>
            <Navbar sd='dash' hideDrop={hideDrop} />
            <MessagesDiv user={fromUserID} />
        </>
    )
}

export default Messages
