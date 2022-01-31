import AddPost from '../../components/AddPost'
import Post from '../../components/Post'
import ANavBar from '../components/ANavBar'
import img2 from '../../images/img1 (2).jpg';
import logo from '../../images/icon.png';
import * as IC from 'react-icons/fa';
import * as aIIC from 'react-icons/ai'
import { PetList } from '../../data/NavData';
import React from 'react'
// import { useLocation} from 'react-router-dom';

function AdmUserProfile() {
    // const location = useLocation()
    // const {fromUserID }= location.state

    return (
        <>
            <ANavBar back={true} admin={true} />
            {/* 'adawdawdawd {fromUserID}' */}
            <div className='UProf-wrapper'>
                <div className='tProp hr'>
                    <div className='covDiv'>
                        <img src={img2} alt='cover' className='covUser' />
                    </div>
                    <div className='dpUser'>
                        <img src={logo} alt='Dp' className='dpImg' />
                        <aIIC.AiFillCamera className='UAddIMG' />
                    </div>
                    <div className='UName'><span>Rolando Allan Ahito</span>(Pet Breeder)</div>
                    <div className='userStat'><span className='folwersC'><p>1</p>Following</span><span className='folwersC'><p>0</p>Followers</span></div>
                </div>
                <div className='bProp'>
                    <div className='Uleft'>
                        <h1 className='Ustle'>About</h1>
                        <div className='userInf hr'>
                            <span><IC.FaHome /><p>Lives in Balanga City, Bataan</p></span>
                            <span><IC.FaMapMarkerAlt /><p>From Bagac, Bataan</p></span>
                            <span><IC.FaHeart /><p>Single</p></span>
                            <span><IC.FaClock /><p>Joined on December 2021</p></span>
                            <span><IC.FaEllipsisH /><p>See your About Info</p></span>
                        </div>
                        <h1 className='Ustle'>Pets</h1>
                        <div className='petInf hr'>
                            {PetList.map((item, index) => {
                                return <div key={index} className='log-in'>
                                    <img src={item.img} alt='pet' />
                                    <span>{item.name}
                                        <div>
                                            <IC.FaGgCircle className='petBadg' />
                                            <IC.FaGgCircle className='petBadg' />
                                            <IC.FaGgCircle className='petBadg' />
                                            <IC.FaGgCircle className='petBadg' />
                                            <IC.FaGgCircle className='petBadg' />
                                            <IC.FaGgCircle className='petBadg' />
                                            <IC.FaGgCircle className='petBadg' />
                                            <IC.FaGgCircle className='petBadg' />
                                            <IC.FaGgCircle className='petBadg' />
                                            <IC.FaGgCircle className='petBadg' />
                                        </div>
                                    </span>
                                </div>
                            })}
                        </div>
                    </div>
                    <div className='Uright'><AddPost /> <Post /></div>
                </div>
            </div>
        </>
    )
}

export default AdmUserProfile
