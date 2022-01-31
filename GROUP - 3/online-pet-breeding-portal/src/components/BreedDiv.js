import React, { Component } from 'react'
import * as fcICons from 'react-icons/fc'
import * as ioIcons from 'react-icons/io5'
import firebase, { auth } from "../config/firebase";
import './Breed.css'
import PetsAvatar from './PetsAvatar';

class BreedDiv extends Component {
    constructor(props) {
        super(props)

        this.state = {
            breedForm: false,
        }
    }
    handleSlt(e, a) {
        if (a === 'all') {
            this.setState({
                specPos: false,
                breedPos: false,
                furPos: false,
                eyePos: false,
                petSpec: '',
                petBreed: '',
                petFur: '',
            });
        } else if (e.target.value === "" && a === 'spec') {
            this.setState({ specPos: false });
        } else if (e.target.value === "" && a === 'breed') {
            this.setState({ breedPos: false });
        } else if (e.target.value === "" && a === 'fur') {
            this.setState({ furPos: false });
        }
    }
    handlegend(a) {
        if (a === 'spec') {
            this.setState({ specPos: true });
        } else if (a === 'breed') {
            this.setState({ breedPos: true });
        } else if (a === 'fur') {
            this.setState({ furPos: true });
        }
    }
    sltChange(e, a) {
        e.preventDefault();
        if (a === 'spec') {
            this.setState({
                selectedPet: null,
                pets: null,
                pets2: null,
                selectedOPet: null,
                petSpec: e.target.value,
            })
        }
        if (a === 'breed') {
            this.setState({
                petBreed: e.target.value,
            })
        }
        if (a === 'fur') {
            this.setState({
                petFur: e.target.value,
            })
        }
    }
    async getMyPets() {

        if (this.state.petSpec === 'Dog') {
            const pets = await firebase.collection("Pets").where("owner", "==", `${auth.currentUser.uid}`).where("species", "==", "Dog").get();
            const pets2 = await firebase.collection("Pets").where("owner", "!=", `${auth.currentUser.uid}`).where("species", "==", "Dog").get();
            this.setState({ pets: pets.docs.map(doc => doc.data()), pets2: pets2.docs.map(doc => doc.data()) })
        } else if (this.state.petSpec === 'Cat') {
            const pets = await firebase.collection("Pets").where("owner", "==", `${auth.currentUser.uid}`).where("species", "==", "Cat").get();
            const pets2 = await firebase.collection("Pets").where("owner", "!=", `${auth.currentUser.uid}`).where("species", "==", "Cat").get();
            this.setState({ pets: pets.docs.map(doc => doc.data()), pets2: pets2.docs.map(doc => doc.data()) })
        }
    }

    setSelectedPet(e) {
        this.setState({ selectedPet: e });
    }
    sendBreedReq() {
        const notif = firebase.collection("Notifications");
        const request = firebase.collection("Breed");
        try {
            request.add({
                myPet: this.state.selectedPet.PetId,
                otherPet: this.state.selectedOPet.PetId,
                sender: auth.currentUser.uid,
                reciever: this.state.selectedOPet.owner,
                method: this.state.petFur,
                status: 'sent',
                viewedByReciever: false,
                viewedBySender: true,
                timestamp: new Date(),
            }).then((breed) => {
                firebase.doc("Breed/" + breed.id).set({ breedID: breed.id, }, { merge: true })
                firebase.doc("Pets/" + this.state.selectedPet.PetId).set({ breeding: true, }, { merge: true })
                firebase.doc("Pets/" + this.state.selectedOPet.PetId).set({ breeding: true, }, { merge: true })
                notif.add({
                    title: "Breed Request",
                    breedID: breed.id,
                    from: auth.currentUser.uid,
                    to: this.state.selectedOPet.owner,
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
    }
    setMethod() {
        if (this.state.selectedPet && this.state.selectedOPet) {
            if (this.state.selectedPet.breed === this.state.selectedOPet.breed) {
                this.setState({ petFur: "Inbreeding" });
            } else {
                this.setState({ petFur: "Cross-Breeding" });
            }
        }
    }
    componentDidMount() {
        this.interval = setInterval(() => {
            this.getMyPets();
            this.setMethod();
        })
    }

    render() {
        return (
            <> <div className="breed-form">
                <div className="breeding-wrapper">
                    <div className="breed-header"><span className='breedtitle'>Breeding</span><ioIcons.IoHome
                        onClick={() => { window.location.href = '/breed' }}
                        title='Close'
                        className='breed-close' />
                    </div>
                    <div className="breed-container">
                        <div className="breeds box">
                            <div className="breedSelected">

                            </div>
                            <h1>My Pets</h1>
                            {this.state.pets && this.state.petSpec ? <><div className='hr'></div>
                                <div className="petInf breedAvatarDiv">
                                    {this.state.pets.map((p, i) => <PetsAvatar
                                        myPet={true}
                                        selectedPet={this.state.selectedPet && this.state.selectedPet.PetId}
                                        setSelected={(e) => { this.setState({ selectedPet: e }) }}
                                        key={i} pet={p} />)}
                                </div></> :
                                <div className='NoSpeciesDiv'>
                                    Select Pet Species
                                </div>}
                        </div>
                        <div className="breeds Opt">
                            <div className="breedSelected" style={{ marginBottom: "10vh" }} >
                                <div className="breedingBtn breedHEart onwe" title='Breed' >
                                    <fcICons.FcLike className="breedBG1" />
                                    <ioIcons.IoPawSharp className="breedBG2" />
                                </div>
                            </div>
                            <div className="Breed_field">
                                <select id='breedSpec' name='breedSpec'
                                    onClick={() => { this.handlegend('spec') }}
                                    onBlur={(e) => { this.handleSlt(e, 'spec') }}
                                    onChange={(e) => { this.sltChange(e, 'spec') }}
                                    value={this.state.petSpec}
                                    className='breedInp'>
                                    <option value='' hidden ></option>
                                    <option value='Dog'>Dog</option>
                                    <option value='Cat'>Cat</option>
                                </select>
                                {/* <ioIcons.IoCaretDown className='selectDown' /> */}
                                <label id='LRSpec'
                                    className={this.state.specPos ? 'label_breed selBreed' : 'label_breed'}
                                    htmlFor="breedSpec">
                                    Species
                                </label>
                            </div>

                            <div className="Breed_field">
                                <select id='breedMethod' name='breedMethod' style={{ pointerEvents: "none" }}
                                    onBlur={(e) => { this.handleSlt(e, 'fur') }}
                                    onChange={(e) => { this.sltChange(e, 'fur') }}
                                    value={this.state.petFur}
                                    className='breedInp'>
                                    <option value='' hidden >Select breeding method</option>
                                    <option value='Inbreeding'>Inbreeding</option>
                                    <option value='Cross-Breeding'>Cross-Breeding</option>
                                </select>
                                {/* <ioIcons.IoCaretDown className='selectDown' /> */}
                                <label id='LRFur'
                                    className={this.state.petFur ? 'label_breed selBreed' : 'label_breed'}
                                    htmlFor="breedMethod">
                                    Method
                                </label>
                            </div>
                            <div className="btn_DIV">
                                <button
                                    className={this.state.selectedOPet && this.state.selectedPet && this.state.petFur ? 'breed_BTN' : 'breed_BTN disabledBreedBtn'}
                                    onClick={() => { this.sendBreedReq() }}>Send Request for Breeding</button>
                            </div>
                        </div>
                        <div className="breeds box">
                            <div className="breedSelected">

                            </div>
                            <h1>Other's Pets</h1>

                            {this.state.pets2 && this.state.petSpec ? <><div className='hr'></div>
                                <div className="petInf breedAvatarDiv">
                                    {this.state.pets2.map((p, i) => <PetsAvatar
                                        otherGender={this.state.selectedPet && this.state.selectedPet.gender}
                                        selectedPet={this.state.selectedOPet && this.state.selectedOPet.PetId}
                                        setSelected={(e) => { this.setState({ selectedOPet: e }) }}
                                        key={i} pet={p} />)}
                                </div></> :
                                <div className='NoSpeciesDiv'>
                                    Select Pet Species
                                </div>}
                        </div>
                    </div>

                </div>
            </div>
            </>
        )
    }
}

export default BreedDiv
