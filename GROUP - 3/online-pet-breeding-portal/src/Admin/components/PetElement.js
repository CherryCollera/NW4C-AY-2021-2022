import BeautyStars from 'beauty-stars';
import React, { Component } from 'react'
import { Link } from 'react-router-dom';
import firebase, {
    // auth
} from "../../config/firebase";
import * as IC1 from 'react-icons/fa'
import Switch from "react-switch";
import './AdmPets.css';

class PetElement extends Component {
    constructor(props) {
        super(props)

        this.state = {
            checked: false
        }
        this.handleChange = this.handleChange.bind(this);
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
        this.setRates(ratess);
    }

    async setRates(a) {
        const ref = firebase.doc(`Pets/${this.props.d.PetId}`);
        const doc = await ref.get();
        if (doc.exists) {
            if (!doc.data().rating) {
                ref.set({
                    rating: a,
                }, { merge: true })
            }
        }
    }

    componentDidMount() {
        this.getAge(this.props.d.bdate, new Date());
        this.getRates(this.props.d.PetId);
        this.getLikes(this.props.d.PetId);
        this.interval = setInterval(() => {
            if (this.props.d.species === 'Dog') {
                if (this.props.d.PetId === this.props.dog) {
                    this.setState({ checked: true });
                } else {
                    this.setState({ checked: false });
                }
            }
            if (this.props.d.species === 'Cat') {
                if (this.props.d.PetId === this.props.cat) {
                    this.setState({ checked: true });
                } else {
                    this.setState({ checked: false });
                }
            }
        });
    }
    async handleChange() {
        if (this.props.d.species === 'Dog') {
            const ref = firebase.doc('featured/dog');
            const doc = await ref.get();
            if (doc.exists) {
                ref.update({ id: this.props.d.PetId, timestamp: new Date() })
                    .then(data => {
                    }).catch(err => {
                        console.log(err);
                    })
            }
        }
        if (this.props.d.species === 'Cat') {
            const ref = firebase.doc('featured/cat');
            const doc = await ref.get();
            if (doc.exists) {
                ref.update({ id: this.props.d.PetId, timestamp: new Date() })
                    .then(data => {
                    }).catch(err => {
                        console.log(err);
                    })
            }
        }
    }

    render() {
        return (
            <div className='allUTab'>
                {this.props.usd === 'Rate' && <span className='swtchPin'>
                    <Switch
                        checked={this.state.checked}
                        onChange={() => { this.handleChange() }}
                        onColor="#86d3ff"
                        onHandleColor="#2693e6"
                        handleDiameter={20}
                        uncheckedIcon={false}
                        checkedIcon={false}
                        boxShadow="0px 1px 10px rgba(0, 0, 0, 0.6)"
                        activeBoxShadow="0px 0px 1px 10px rgba(0, 0, 0, 0.2)"
                        height={20}
                        width={30}
                        className="react-switch"
                        id="material-switch"
                    />
                </span>}
                <span style={this.props.usd === 'All' ? { gridColumn: '1/5' } : { gridColumn: '2/6' }}>{this.props.d.name}</span>
                <span style={this.props.usd === 'All' ? { gridColumn: '5/8' } : { gridColumn: '6/9' }}>{this.props.d.species}</span>
                <span style={this.props.usd === 'All' ? { gridColumn: '8/11' } : { gridColumn: '9/12' }}>{this.props.d.breed}</span>
                {this.props.usd === 'All' && (<>
                    <span style={{ gridColumn: '11/14' }}>{this.state.age && this.state.age[0].age} </span>
                    <span style={{ gridColumn: '14/17' }} title='Status' >{this.props.d.breeding ? <div className='ofl'>Breeding</div> : <div className='onl'>Available</div>} </span>
                    <span style={{ gridColumn: '17/21' }} >
                        <Link
                            to={{ pathname: `/pets/${this.props.d.PetId}`, state: { fromPetID: `${this.props.d.PetId}` } }}>
                            View Profile
                        </Link>
                    </span>
                </>)}
                {this.props.usd === 'Rate' && (<>
                    <span style={this.props.usd === 'All' ? { gridColumn: '11/14' } : { gridColumn: '12/14' }}>{this.state.likes && this.state.likes}<IC1.FaHeart style={{ color: "red", marginLeft: "1vh" }} /></span>
                    <span style={{ gridColumn: '14/18', justifyContent: "space-between", display: 'flex', flexDirection: "row", padding: "0 4vh", textAlign: "center" }} >
                        {this.state.raters > 0 ? <> <BeautyStars
                            inactiveColor="var(--boColor)"
                            activeColor="var(--primaryTextColor)"
                            size={'2vh'}
                            value={this.state.rate}
                            editable={false}
                        /> {` ${this.state.rate}`}</>
                            : <span style={{ marginLeft: "8vh" }}>Unrated</span>}
                    </span>
                    <span style={{ gridColumn: '18/21' }} >
                        <Link
                            to={{ pathname: `/pets/${this.props.d.PetId}`, state: { fromPetID: `${this.props.d.PetId}` } }}>
                            View Profile
                        </Link>
                    </span>
                </>)}

            </div>
        )
    }
}

export default PetElement
