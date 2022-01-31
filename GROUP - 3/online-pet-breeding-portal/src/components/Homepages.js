import React from 'react'
import Features from './Features';
import './Homepages.css'
import Teams from './Teams';

function Homepages() {


  return (
    <>
      <div className='container' >
        <div id='home' className='nav-pages'>
          <div className='tis'>
            {/* <p className='portrait'>{text}</p> */}
            <h1 className='til'>Online Pet Breeding Portal</h1>
            <h3 className='til2'>Many owners find the companionship of their dog so
              rewarding that they feel they would like to breed their dog,
              to continue the bloodline and/or to keep a puppy. Others,
              especially first time dog owners, will acquire a female dog
              with the intent to breed her when she is old enough.
            </h3>
            {/* <button onClick={() => { sendMail() }}>Send Mail</button> */}
          </div>
          <div className='los'>
            <div className='divsi'>
              <h1>Mission</h1>
              <p>To provide an innovative services that helps users to find the nearest pet breeder around their location. promotes an excellent healthcare and has an innovative,  pet friendly manner which gives a memorable service experience to the users.</p>
            </div>
            <div className='divsi'>
              <h1>Vision</h1>
              <p>Our vision is to create a virtual place here in bataan in which every pet breeder and pet owner will benefitted. the developed system has the ability to meet and surpass the service demand and expectations of the users.</p>
            </div>
          </div>
        </div>
        <div id='features' className='nav-pages'><Features /></div>
        <div id='team' className='nav-pages'>
          <div className='about_us'>
            <h1>About us</h1>
            <p>We created the first version of Bataan Online Pet Breeding Management Portal in 2021 as a web portal and give it away for free. Our web portal will helped the pet owners to look for other nearest pet breeders in Bataan. It also help the pet breeders and pet owners to manage the breeding and to monitor the breeding process by sending a status of breeding.</p>
          </div>
          <div className='gridTeam'>
            <Teams teamName="Vincent Ilao"
              teamImg={<img alt='sc' src='https://firebasestorage.googleapis.com/v0/b/online-pet-breeding-portal.appspot.com/o/assets%2F258308614_296936402302165_2269420317358196040_n.jpg?alt=media&token=be37fd51-dbf6-446c-a2cd-4c5cf1b18973'
                className='teamImage' />}
              teamRole='Leader'
              teamDesc='Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt'
              f='https://www.facebook.com/profile.php?id=100000220683429'
              t='https://twitter.com/jeyvieeeee'
              i='https://www.instagram.com/jeyvieeee/'
              g='johnvincent0818@gmail.com' />
            <Teams teamName="Davilyn Dinio"
              teamImg={<img alt='sc' src='https://firebasestorage.googleapis.com/v0/b/online-pet-breeding-portal.appspot.com/o/assets%2F256416039_427232232298359_6065324141852971301_n.jpg?alt=media&token=b8d242bb-13a9-4f1a-a186-888d9dd78fbe' className='teamImage' />}
              teamRole='Web Designer'
              teamDesc='Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt'
              f='https://www.facebook.com/dav.dinio'
              i='https://www.instagram.com/davilyndinio/'
              t='https://twitter.com/Dabelene14'
              g='davilyndinio@gmail.com' />
            <Teams teamName="Marissa Mendoza"
              teamImg={<img alt='sc' src='https://firebasestorage.googleapis.com/v0/b/online-pet-breeding-portal.appspot.com/o/assets%2F257738629_989015068310405_3627430328385209970_n.jpg?alt=media&token=02086b33-f317-4ea1-b4c6-cf4d20ee41d1' className='teamImage' />}
              teamRole='Web Designer'
              teamDesc='Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt'
              f='https://www.facebook.com/cadaveeer'
              i='https://www.instagram.com/mariiiiiisssss/?hl=en'
              t='https://mobile.twitter.com/mariiiisssss'
              g='psai.mendoza@gmail.com' />
            <Teams teamName="Rolando Lazo"
              teamImg={<img alt='sc' src='https://firebasestorage.googleapis.com/v0/b/online-pet-breeding-portal.appspot.com/o/assets%2FIMG20200903134944.jpg?alt=media&token=d0790341-cbd3-418d-b710-0b6eb33ad6a7' className='teamImage' />}
              teamRole='Web Developer '
              teamDesc='Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt'
              f='https://www.facebook.com/rie.lazo/'
              t='https://twitter.com/MrAhito'
              i='https://www.instagram.com/landoxx22/'
              g='rqlazo@bpsu.edu.ph'
            />
          </div>
        </div>
        {/* {/* <div id='about' className='nav-pages'><About /></div>
        <div id='about' style={{ marginTop: "-40vh" }} className='nav-pages'><MissionVision /></div> */}
      </div>
    </>
  )
}

export default Homepages
