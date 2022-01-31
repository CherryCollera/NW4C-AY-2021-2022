import React, { Component } from 'react'
import './Features.css';
import "react-responsive-carousel/lib/styles/carousel.min.css"; // requires a loader
import { Carousel } from 'react-responsive-carousel';
import img1 from '../images/feat1.jpg';
import * as Icons from 'react-icons/fa'
// import img2 from '../images/f2.jpg';
// import img3 from '../images/f3.jpg';
import firebase from "../config/firebase";
import FeaturedPet from './FeaturedPet';

class Features extends Component {
    constructor() {
        super()

        this.state = {
            fcat: [],
            fdog: [],
            counter: 0,
            titles: ['', '', '', ''],
            subs: ['', '',
                '',
                ''],
        }
    }

    bark() {
        let audio = new Audio("../audio/bark.wav");
        audio.play();
    }

    meow() {
        let audio = new Audio("../audio/kitten3.wav");
        audio.play();
    }


    async getFeatured() {
        const ref = firebase.doc('featured/dog');
        const ref2 = firebase.doc('featured/cat');
        const doc = await ref.get();
        const doc2 = await ref2.get();
        if (doc.exists) {
            const petRef = firebase.doc('Pets/' + doc.data().id);
            const pet = await petRef.get();
            if (pet.exists) {
                this.setState({ fdog: pet.data() });
            }
        }
        if (doc2.exists) {
            const petRef = firebase.doc('Pets/' + doc2.data().id);
            const pet = await petRef.get();
            if (pet.exists) {
                this.setState({ fcat: pet.data() });
            }
        }
    }


    componentDidMount() {
        this.getFeatured();
    }

    render() {
        return (
            <div className='slider'>
                <Carousel onChange={(i, da) => {
                    this.setState({ data: i })
                }}
                    infiniteLoop={true}
                    // autoPlay={true}
                    showStatus={false}
                    showThumbs={false}>
                    <div>
                        <div className='imgBTn_carousel'>
                            <div onClick={() => { this.bark() }} className='btn_carousel'><Icons.FaBone /></div>
                            <div className='middleBtn'></div>
                            <div onClick={() => { this.meow() }} className='btn_carousel'><Icons.FaFish /></div>
                        </div>
                        <img className='divCarousel' alt=" " src={img1} />
                    </div>
                    <div>
                        <FeaturedPet data={this.state.fdog} />
                    </div>
                    <div>
                        <FeaturedPet data={this.state.fcat} />
                    </div>
                </Carousel>
            </div>
        )
    }
}

export default Features