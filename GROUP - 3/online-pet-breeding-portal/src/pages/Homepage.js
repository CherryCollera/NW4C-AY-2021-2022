import React from 'react'
import Footer from '../components/Footer'
import Homepages from '../components/Homepages'
import Navbar from '../components/Navbar'

function Homepage() {

  return (
    <>
      <Navbar sd='home' />
      <Homepages />
      <Footer />
    </>
  )
}

export default Homepage
