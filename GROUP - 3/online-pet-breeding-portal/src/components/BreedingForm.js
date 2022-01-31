import React, { Component } from 'react'
import firebase, { auth } from "../config/firebase";
import * as  Icon1 from 'react-icons/ai';
import * as  Icon2 from 'react-icons/fa';
import * as  Icon3 from 'react-icons/gi';
import './BreedingForm.css';
import PetSelect from './PetSelect';
import { BreedBeagle, BreedChihuahua, BreedDalmatian, BreedDoberman, BreedGerman, BreedGolden, BreedLabrador, BreedPoodle, BreedPug, BreedShih } from '../data/data';
import { getDoc } from '../Functions/Functions';

class BreedingForm extends Component {
    constructor(props) {
        super(props)

        this.state = {
            pets: [],
            oter: [],
            type: 0,
            oage: 0,
            age: 0,
            olike: 0,
            like: 0,
            petDistance: ' ',
            rate: 0,
            orate: 0,
            comp: '0%',
        }
    }

    handleCarrets(a) {
        if (a) {
            this.setState({ type: this.state.type + 1 });
        } else {
            this.setState({ type: this.state.type - 1 })
        }
        this.setState({
            Oth_selected: '',
            Pet_selected: '',
            oage: 0,
            age: 0,
            olike: 0,
            like: 0,
            rate: 0,
            orate: 0,
            comp: '0%',
        })
    }
    resetOther() {
        this.setState({
            Oth_selected: '',
            olike: 0,
            oage: 0,
            petDistance: 0,
            orate: 0,
            comp: '0%',
        })
    }

    getCompativility(a, b) {
        var data;
        if (a.breed === 'Beagle') {
            data = BreedBeagle;
        }
        if (a.breed === 'Poodle') {
            data = BreedPoodle;
        }
        if (a.breed === 'Pug') {
            data = BreedPug;
        }
        if (a.breed === 'Golden Retriever') {
            data = BreedGolden;
        }
        if (a.breed === 'Dalmatian') {
            data = BreedDalmatian;
        }
        if (a.breed === 'Shih Tzu') {
            data = BreedShih;
        }
        if (a.breed === 'Chihuahua') {
            data = BreedChihuahua;
        }
        if (a.breed === 'German Shepard') {
            data = BreedGerman;
        }
        if (a.breed === 'Doberman') {
            data = BreedDoberman;
        }
        if (a.breed === 'Labrador Retriever') {
            data = BreedLabrador;
        }
        if (data) {
            data.map((d, i) => {
                if (d.text === b.breed) {
                    this.setState({ comp: d.value + '%' });
                }
                return true;
            })
        }
    }

    sendBreedReq() {
        if (this.state.Oth_selected && this.state.Pet_selected) {
            var method = 'INBREEDING';
            const notif = firebase.collection("Notifications");
            const request = firebase.collection("Breed");
            if (this.state.Oth_selected.breed !== this.state.Pet_selected.breed) {
                method = 'CROSS-BREEDING';
            }
            try {
                request.add({
                    myPet: this.state.Pet_selected.PetId,
                    otherPet: this.state.Oth_selected.PetId,
                    sender: auth.currentUser.uid,
                    reciever: this.state.Oth_selected.owner,
                    method: method,
                    status: 'sent',
                    viewedByReciever: false,
                    viewedBySender: true,
                    timestamp: new Date(),
                }).then((breed) => {
                    firebase.doc("Breed/" + breed.id).set({ breedID: breed.id, }, { merge: true })
                    firebase.doc("Pets/" + this.state.Pet_selected.PetId).set({ breeding: true, }, { merge: true })
                    firebase.doc("Pets/" + this.state.Oth_selected.PetId).set({ breeding: true, }, { merge: true })
                    notif.add({
                        title: "Breed Request",
                        breedID: breed.id,
                        from: auth.currentUser.uid,
                        to: this.state.Oth_selected.owner,
                        timestamp: new Date(),
                        viewedByReciever: false,
                    }).then((notif) => {
                        firebase.doc("Notifications/" + notif.id).set({ notifID: notif.id, }, { merge: true });
                        alert("Breeding request sent wait for Breeder response, Thank you!");
                        window.location.href = '/breed';

                    })
                })
            } catch (err) {
                console.log(err);
            }
        } else {
            alert("Please select pets to breed, Thank you!");
        }
    }



    componentDidMount() {
        auth.onAuthStateChanged(user => {
            if (user) {
                this.interval = setInterval(() => {
                    if (this.state.type % 2 === 0) {
// .where("breedable", "==", true)
                        firebase.collection("Pets").where('owner', '==', user.uid).where('species', '==', 'Dog').where("breedable", "==", true).where("breeding", "==", false).onSnapshot(snaps => {
                            this.setState({ pets: snaps.docs.map(doc => doc.data()) });
                        });
                        firebase.collection("Pets").where('owner', '!=', user.uid).where('species', '==', 'Dog').where("breedable", "==", true).where("breeding", "==", false).onSnapshot(snaps => {
                            this.setState({ oter: snaps.docs.map(doc => doc.data()) });
                        })
                    } else {
                        firebase.collection("Pets").where('owner', '==', user.uid).where('species', '==', 'Cat').where("breedable", "==", true).where("breeding", "==", false).onSnapshot(snaps => {
                            this.setState({ pets: snaps.docs.map(doc => doc.data()) });
                        });
                        firebase.collection("Pets").where('owner', '!=', user.uid).where('species', '==', 'Cat').where("breedable", "==", true).where("breeding", "==", false).onSnapshot(snaps => {
                            this.setState({ oter: snaps.docs.map(doc => doc.data()) });
                        })
                    }
                    getDoc(firebase, auth.currentUser.uid).then(d => {
                        this.setState({ user: d });
                    })
                    if (this.state.Pet_selected && this.state.Oth_selected) {
                        this.getCompativility(this.state.Pet_selected, this.state.Oth_selected);
                        getDoc(firebase, this.state.Oth_selected.owner).then(d => {
                            this.setState({ other: d });
                        })
                    }
                });
            }
        })


    }

    render() {
        return (
            <div className='Pet_Breeding'>
                <div className='Pet_wrapper'>
                    <div className='Top _breed'>
                        <div className='sideTop'>
                            <div className='side_Top'>
                                {this.state.Pet_selected && <> {(this.state.Pet_selected.profile ? <img className='img' src={this.state.Pet_selected.profile} alt='dp' /> :
                                    <div style={{ backgroundColor: this.state.Pet_selected.bgColor }} className='img' >{this.state.Pet_selected.name && this.state.Pet_selected.name[0]}</div>)}
                                    <center><a href={`Pets/${this.state.Pet_selected.PetId}`}>View Profile</a></center>
                                </>}
                            </div>
                            <div className='side_Bot'>
                                {this.state.pets && <PetSelect data={this.state.pets}
                                    resetOther={() => { this.resetOther() }}
                                    setRates={(e) => { this.setState({ rate: e }) }}
                                    setLikes={(e) => { this.setState({ like: e }) }}
                                    setAge={(e) => { this.setState({ age: e }) }}
                                    selected={this.state.Pet_selected}
                                    setSelected={(e) => { this.setState({ Pet_selected: e }) }} />}
                            </div>
                        </div>
                        <div className='centerTop'>
                            <h1>BREEDING</h1>
                            <div className="breedType_">
                                <Icon1.AiFillCaretLeft
                                    onClick={() => { this.handleCarrets(false) }}
                                    className='caret' />
                                {this.state.type % 2 === 0
                                    ? <Icon2.FaDog className='petType' />
                                    : <Icon2.FaCat className='petType cat' />}
                                <Icon1.AiFillCaretRight
                                    onClick={() => { this.handleCarrets(true) }}
                                    className='caret' />
                            </div>
                            <div className='mnetho'>
                                {this.state.Oth_selected && this.state.Pet_selected && <>
                                    <h1>{this.state.Oth_selected.breed === this.state.Pet_selected.breed
                                        ? 'INBREEDING'
                                        : 'CROSS-BREEDING'}</h1>
                                    {this.state.type % 2 === 0
                                        ? <Icon2.FaBone className='metho_' />
                                        : <Icon3.GiFishbone className='metho_ cato' />}
                                    <span>Method</span>
                                </>}
                            </div>
                            <button className='btn-log sendREQ' onClick={() => { this.sendBreedReq() }}>Send Breeding Request</button>
                        </div>
                        <div className='sideTop'>
                            <div className='side_Top'>
                                {this.state.Oth_selected && <>{(this.state.Oth_selected.profile ? <img className='img' src={this.state.Oth_selected.profile} alt='dp' /> :
                                    <div style={{ backgroundColor: this.state.Oth_selected.bgColor }} className='img' >{this.state.Oth_selected.name && this.state.Oth_selected.name[0]}</div>)}
                                    <center><a href={`Pets/${this.state.Oth_selected.PetId}`}>View Profile</a></center>
                                </>}
                            </div>
                            <div className='side_Bot'>
                                {this.state.oter && <PetSelect data={this.state.oter}
                                    selected={this.state.Oth_selected}
                                    PetDistance={(e) => { this.setState({ petDistance: e }) }}
                                    gender={this.state.Pet_selected && this.state.Pet_selected.gender}
                                    setRates={(e) => { this.setState({ orate: e }) }}
                                    setAge={(e) => { this.setState({ oage: e }) }}
                                    setLikes={(e) => { this.setState({ olike: e }) }}
                                    setSelected={(e) => { this.setState({ Oth_selected: e }) }} />}
                            </div>
                        </div>
                    </div>
                    <div className='Mid _breed'>
                        <div className='sideTop comp'>
                            <div className='comp_ sideaa'>
                                <div className='heasders_'  style={{width: `${this.state.age > 10 ? 100 :  this.state.age / 10 * 100}%`}}><div className='headers_Data asad'>{this.state.age}</div></div>
                                <div className='heasders_' style={{width: `${this.state.like / 10 * 100}%`}}><div className='headers_Data asad'>{this.state.like}</div></div>
                                <div className='heasders_' style={{width:`${this.state.rate * 20}%`}}><div className='headers_Data asad' >{this.state.rate}</div></div>
                                <div className='heasders_' style={{width:`${this.state.comp}`}}><div className='headers_Data asad' >{this.state.comp}</div></div>
                            </div>
                        </div>
                        <div className='centerTop comp'>
                            <div className='tube_'></div>
                            <div className='comp_ mida'>
                                <div className='heasders_'>Age(years)</div>
                                <div className='heasders_'>Likes</div>
                                <div className='heasders_'>Ratings</div>
                                <div className='heasders_'>Compatibility</div>
                            </div>
                        </div>
                        <div className='sideTop comp'>
                            <div className='comp_ sideba'>
                                <div className='heasders_' style={{width: `${this.state.oage > 10 ? 100 :  this.state.oage / 10 * 100}%`}}><div className='headers_Data dasa'>{this.state.oage}</div></div>
                                <div className='heasders_' style={{width: `${this.state.olike / 10 * 100}%`}}><div className='headers_Data dasa'>{this.state.olike}</div></div>
                                <div className='heasders_' style={{width:`${this.state.orate * 20}%`}}><div className='headers_Data dasa' >{this.state.orate}</div></div>
                                <div className='heasders_' style={{width:`${this.state.comp}`}}><div className='headers_Data dasa' >{this.state.comp}</div></div>
                            </div>
                        </div>
                    </div>
                    <div className='Bot _breed'>
                        <div className='Abo owner_'>
                            <div className='dpImageLoc'><Icon2.FaMapMarkerAlt />
                                {this.state.user && (this.state.user.profile ? <div className='dp-wrapper'>
                                    <img className='adProp' src={this.state.user.profile} alt='dp' />
                                </div> : <div style={{ backgroundColor: this.state.user.bgColor }} className='dp-wrapper' >
                                    {this.state.user.first_name && this.state.user.first_name[0]}
                                </div>)}
                            </div>
                            {this.state.user && <span> {this.state.user.address && this.state.user.address}</span>}
                        </div>
                        <div className='Loc owner_'>
                            <span>{this.state.Pet_selected && this.state.Oth_selected && `${this.state.petDistance} `} </span>
                            <Icon3.GiPathDistance />
                        </div>
                        <div className='Abo2 owner_'>
                            <div className='dpImageLoc'>
                                {this.state.Pet_selected && this.state.Oth_selected && this.state.other && this.state.other.location && <><Icon2.FaMapMarkerAlt />
                                    {this.state.other.profile ?
                                        <div className='dp-wrapper'>
                                            <img className='adProp' src={this.state.other.profile} alt='dp' />
                                        </div> : <div style={{ backgroundColor: this.state.other.bgColor }} className='dp-wrapper' >
                                            {this.state.other.first_name && this.state.other.first_name[0]}
                                        </div>}
                                </>}
                            </div>
                            {this.state.Pet_selected && this.state.Oth_selected && this.state.other && this.state.other.location && <span> {this.state.other.address && this.state.other.address}</span>}
                        </div>
                    </div>
                </div>
            </div >
        )
    }
}

export default BreedingForm
