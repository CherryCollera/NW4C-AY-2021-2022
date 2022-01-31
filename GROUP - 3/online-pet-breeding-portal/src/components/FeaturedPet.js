import BeautyStars from 'beauty-stars';
import React, { Component } from 'react'
import firebase from "../config/firebase";
import { getDoc } from '../Functions/Functions';
import logo2 from '../images/featdogbg.svg'
import logo from '../images/featcatbg.svg'
import * as IC1 from 'react-icons/fa'
import './FeaturedPet.css'
class FeaturedPet extends Component {
    constructor(props) {
        super(props)

        this.state = {
        }
    }
    getAge(a, b) {
        var dt1 = new Date(a);
        var diff = (b.getTime() - dt1.getTime()) / 1000;
        diff /= (60 * 60 * 24);
        diff = Math.abs(Math.ceil(1 * (diff)));
        var year = 365.25;
        var month = 31;
        var yearCount = 0;
        var monthCount = 0;
        if (diff > year) {
            while ((diff - year) > 0) {
                diff -= year;
                yearCount++;
                if (diff < year) {
                    while (diff > month) {
                        diff -= month;
                        monthCount++;
                    }
                }
            }
        } else {
            while (diff > month) {
                diff -= month;
                monthCount++;
                if (monthCount === 12) {
                    monthCount = 11;
                }
            }
        }
        this.setState({ age: [{ y: yearCount, m: monthCount, age: yearCount + Math.round((monthCount / 12) * 10) / 10 }] });
    }


    async getLikes(a) {
        const likes = await firebase.collection(`Pets/${a}/likes`).get();
        this.setState({ likes: likes.size });
    }


    async getRates(a) {
        var ratess = 0;
        const rates = await firebase.collection(`Pets/${a}/rates`).get();
        if (rates.empty) {
            ratess = 'N/A';
        } else {
            rates.docs.map(docs => {
                ratess += docs.data().value;
                return true;
            });
            ratess = ratess / rates.size;
        }
        this.setState({ rate: ratess, raters: rates.size });
    }

    componentDidMount() {
        if (this.props.data) {
            this.interval = setInterval(() => {
                this.getAge(this.props.data.bdate, new Date());
                this.getRates(this.props.data.PetId);
                this.getLikes(this.props.data.PetId);
                getDoc(firebase, this.props.data.owner).then(data => {
                    this.setState({ owner: data })
                })
            });
        }
    }

    render() {
        return <>
            {this.props.data &&
                <div className='pet_panel'>
                    <h1>FEATURED</h1>
                    <h2>{this.props.data.species}</h2>
                    {this.props.data.species === 'Cat' ?
                        <img src={logo} alt='bg' className='bgFeat' />
                        :
                        <img src={logo2} alt='bg' className='bgFeat ' />
                    }
                    <div className='info-wrapper'>
                        <div className={this.props.data.species === 'Cat' ? 'top-div rev' : 'top-div'}>
                            <div className='pet-Profile'>
                                {this.props.data && this.props.data.profile ? <img className='img imgFeat mobileF' src={this.props.data.profile} alt='dp' /> :
                                    <div style={{ backgroundColor: this.props.data.bgColor }} className='img imgFeat' >{this.props.data.name && this.props.data.name[0]}</div>}
                                <strong>{this.props.data.name}</strong>
                                <span style={{ color: "var(--primaryColor)" }}>({this.props.data.breed})</span>
                            </div>
                            {this.state.owner && <div className='owner-profile'>
                                {this.state.owner.profile ? <div className='dp-wrapper' >
                                    <img className='adProp' src={this.state.owner.profile} alt='dp' />
                                </div> : <div style={{ backgroundColor: this.state.owner.bgColor }} className='dp-wrapper' >
                                    {this.state.owner.first_name && this.state.owner.first_name[0]}
                                </div>}
                                <p style={{ color: "var(--primaryColor)" }}>(owner)</p>
                                <span>{this.state.owner.first_name} {this.state.owner.last_name}</span>
                            </div>}

                        </div>
                        <div className='bot-div'>
                            <BeautyStars
                                inactiveColor="var(--boColor)"
                                activeColor="var(--primaryTextColor)"
                                size={'4.5vh'}
                                value={this.state.rate}
                                editable={false}
                            />
                            <div className='loikes' title={`${this.state.likes} likes`}>
                                <span>{this.state.likes}</span>
                                <IC1.FaHeart />
                            </div>
                        </div>
                    </div>
                </div>}

        </>
    }
}

export default FeaturedPet
