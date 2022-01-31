import React, { Component } from 'react'
import './About.css'
import logo from '../images/logo.png'
import * as faICons from 'react-icons/fa'

class About extends Component {
    render() {
        return (
            <>
                <div className='socDiv'>
                    <img src={logo} alt='logo' className='aboutLogo' />
                    <div className='socmed'>
                        <faICons.FaFacebookF className='socs' title='Facebook' />
                        <faICons.FaInstagram className='socs' title='Instagram' />
                        <faICons.FaTwitter className='socs' title='Twitter' />
                        <faICons.FaRedditAlien className='socs' title='Reddit' />
                        <faICons.FaLinkedin className='socs' title='LinkedIn' />
                    </div>
                </div>
                <div className='aboutDiv'>
                    <div className='about'>
                        <h1>About Us</h1>
                        <p>We created the first version of Bataan Online Pet Breeding Management Portal in 2021 as a web portal and give it away for free. Our web portal will helped the pet owners to look for other nearest pet breeders in Bataan. It also help the pet breeders and pet owners to manage the breeding and to monitor the breeding process by sending a status of breeding</p>
                        {/* <ul>
                    <li><a href='\' title='Our Story'>Our Story</a></li>
                    <li><a href='\' title='Careers'>Careers</a></li>
                    <li><a href='\' title='Why Animal Rights?'>Why Animal Rights?</a></li>
                    <li><a href='\' title='Victories'>Victories</a></li>
                    <li><a href='\' title='Volunteer'>Volunteer</a></li>
                </ul> */}
                    </div>
                    {/* <div className='about'>
                        <h1>Help Animals</h1>
                        <ul>
                            <li><a href='\' title='Urgent Alerts'>Urgent Alerts</a></li>
                            <li><a href='\' title='Our Campaigns'>Our Campaigns</a></li>
                            <li><a href='\' title='Join the Action Team'>Join the Action Team</a></li>
                            <li><a href='\' title='For Students'>For Students</a></li>
                            <li><a href='\' title='For Teachers'>For Teachers</a></li>
                        </ul>
                    </div>
                    <div className='about'>
                        <h1>For Media</h1>
                        <ul>
                            <li><a href='\' title='Media Center'>Media Center</a></li>
                            <li><a href='\' title='News Releases'>News Releases</a></li>
                            <li><a href='\' title='PSAs'>PSAs</a></li>
                            <li><a href='\' title='For Media: Order PSAs'>For Media: Order PSAs</a></li>
                            <li><a href='\' title='Contact Media Team'>Contact Media Team</a></li>
                        </ul>
                    </div> */}
                </div>

            </>
        )
    }
}

export default About
