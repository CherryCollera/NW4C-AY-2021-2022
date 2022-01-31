import React, { Component } from 'react'
import { VerticalTimelineElement } from 'react-vertical-timeline-component';
import 'react-vertical-timeline-component/style.min.css';
import firebase, { auth } from "../config/firebase";
import { getDoc } from '../Functions/Functions';
import { Link } from 'react-router-dom';
import * as IC1 from 'react-icons/fa'
import './BreedList.css'
import moment from 'moment';
import Feedback from './Feedback';
import BeautyStars from "beauty-stars";

class BreedList extends Component {
    constructor(props) {
        super(props)

        this.state = {
            owner_name: '',
            other_pet: '',
            other: '',
            rateBtn: false,
            pet: '',
            duration: 0,
            duration2: 0,
            rating: '',
        }
    }

    async getDatas(a, b, c) {
        if (this.props.data.finishedBy) {
            if (this.props.data.finishedBy === auth.currentUser.uid) {
                this.setState({ finByName: 'You' })
            } else {
                await getDoc(firebase, this.props.data.finishedBy).then(data => {
                    if (!data.empty) {
                        this.setState({ finByName: data.first_name + " " + data.middle_name[0] + ". " + data.last_name, finBy: data });
                    }
                })
            }
        }
        if (this.props.used === 'dec') {
            this.setState({ duration2: moment(this.props.data.cts.toDate(), "YYYYMMDD").fromNow() });
        }
        if (this.props.used === 'fin') {
            this.setState({ duration: this.props.data.timestamp.toDate().toDateString() });
        } else {
            this.setState({ duration: this.props.data.timestamp.toDate().toDateString() });
        }



        await getDoc(firebase, a).then(data => {
            if (!data.empty) {
                this.setState({ owner_name: data.first_name + " " + (data.middle_name && data.middle_name[0] + ". ") + data.last_name, owner: data });
            }
        })
        const doc = await firebase.doc(`Pets/${b}`).get();
        if (!doc.empty) {
            this.setState({ other_pet: doc.data() });
        }
        const doc2 = await firebase.doc(`Pets/${c}`).get();
        if (!doc2.empty) {
            this.setState({ pet: doc2.data() });
        }
    }

    async setView(a) {
        const ref = await firebase.collection(`Notifications`).where("breedID", '==', a).get();
        if (!ref.empty) {
            const notifID = ref.docs[0].data().notifID;
            const viewd = ref.docs[0].data().viewedByReciever;
            const NotifRef = firebase.doc(`Notifications/${notifID}`);
            if (!viewd) {
                try {
                    NotifRef.set({
                        timestamp: new Date(),
                        viewedByReciever: true,
                    }, { merge: true })
                } catch (error) {
                    console.log(error);
                }
            }

        }
    }

    accept() {
        const ref = firebase.doc(`Breed/${this.props.data.breedID}`);
        try {
            ref.set({ status: 'ongoing', ots: new Date() }, { merge: true });
        } catch (err) {
            console.log(err);
        }
    }

    async decline(a) {
        const ref = firebase.doc(`Breed/${this.props.data.breedID}`);
        const pet1 = firebase.doc(`Pets/${this.state.pet.PetId}`);
        const pet2 = firebase.doc(`Pets/${this.state.other_pet.PetId}`);
        const ref2 = await firebase.collection(`Notifications`).where("breedID", '==', this.props.data.breedID).get();
        if (!ref2.empty) {
            const recieverID = ref2.docs[0].data().from;
            const NotifRef = firebase.collection(`Notifications`);
            try {
                pet1.set({ breeding: false }, { merge: true });
                pet2.set({ breeding: false }, { merge: true });
                ref.set({ status: 'declined', Res: a, cts: new Date(), finishedBy: auth.currentUser.uid, }, { merge: true });
                NotifRef.add({
                    title: "Declined Request",
                    breedID: this.props.data.breedID,
                    from: auth.currentUser.uid,
                    to: recieverID,
                    timestamp: new Date(),
                    viewedByReciever: false,
                }).then((notif) => {
                    firebase.doc("Notifications/" + notif.id).set({ notifID: notif.id, }, { merge: true });
                    alert("Breeding request declined");
                    window.location.href = '/breed#declined';

                })
            } catch (err) {
                console.log(err);
            }
        }

    }
    complete() {
        const ref = firebase.doc(`Breed/${this.props.data.breedID}`);
        const pet1 = firebase.doc(`Pets/${this.state.pet.PetId}`);
        const pet2 = firebase.doc(`Pets/${this.state.other_pet.PetId}`);
        try {
            pet1.set({ breeding: false }, { merge: true });
            pet2.set({ breeding: false }, { merge: true });
            ref.set({ status: 'finished', fts: new Date(), finishedBy: auth.currentUser.uid, duration: this.state.duration }, { merge: true });
        } catch (err) {
            console.log(err);
        }
    }
    async cancel(a) {
        const ref = firebase.doc(`Breed/${this.props.data.breedID}`);
        const pet1 = firebase.doc(`Pets/${this.state.pet.PetId}`);
        const pet2 = firebase.doc(`Pets/${this.state.other_pet.PetId}`);
        const ref2 = await firebase.collection(`Notifications`).where("breedID", '==', this.props.data.breedID).get();
        if (!ref2.empty) {
            const recieverID = ref2.docs[0].data().to;
            const NotifRef = firebase.collection(`Notifications`);
            try {
                pet1.set({ breeding: false }, { merge: true });
                pet2.set({ breeding: false }, { merge: true });
                ref.set({ status: 'cancelled', Res: a, cts: new Date(), finishedBy: auth.currentUser.uid }, { merge: true });
                NotifRef.add({
                    title: "Cancel Request",
                    breedID: this.props.data.breedID,
                    from: auth.currentUser.uid,
                    to: recieverID,
                    timestamp: new Date(),
                    viewedByReciever: false,
                }).then((notif) => {
                    firebase.doc("Notifications/" + notif.id).set({ notifID: notif.id, }, { merge: true });
                    alert("Breeding request cancelled");
                    window.location.href = '/breed#declined';

                })
            } catch (err) {
                console.log(err);
            }

        }
    }


    async getRates() {
        const pet1 = await firebase.doc(`Pets/${this.props.data.myPet}`).get();
        const pet2 = await firebase.doc(`Pets/${this.props.data.otherPet}`).get();
        const rateRef = await firebase.collection(`Pets/${pet1.data().PetId}/rates/`).where("breedID", "==", this.props.data.breedID).get();
        const rateRef2 = await firebase.collection(`Pets/${pet2.data().PetId}/rates/`).where("breedID", "==", this.props.data.breedID).get();
        if (!rateRef.empty) {
            rateRef.docs.map(docs => {
                if (docs.data().rater === auth.currentUser.uid) {
                    this.setState({ rating: docs.data() })
                } else {
                    this.setState({ rating2: docs.data() })
                    console.log(docs.data());
                }
                return true;
            })
        }
        if (!rateRef2.empty) {
            rateRef2.docs.map(docs => {
                if (docs.data().rater === auth.currentUser.uid) {
                    this.setState({ rating: docs.data() })
                } else {
                    this.setState({ rating2: docs.data() })
                }
                return true;
            })
        }
    }
    componentDidMount() {
        this.interval = setInterval(() => {
            if (this.props.used === 'req') {
                this.getDatas(this.props.data.reciever, this.props.data.otherPet, this.props.data.myPet);
            } else if (this.props.used === 'pen' && this.props.data) {
                this.getDatas(this.props.data.sender, this.props.data.myPet, this.props.data.otherPet);
            }
            if (this.props.used === 'onh') {
                if (this.props.data.sender === auth.currentUser.uid) {
                    this.getDatas(this.props.data.reciever, this.props.data.myPet, this.props.data.otherPet);
                } else {
                    this.getDatas(this.props.data.sender, this.props.data.myPet, this.props.data.otherPet);
                }
            }
            if (this.props.used === 'dec') {
                if (this.props.data.sender === auth.currentUser.uid) {
                    this.getDatas(this.props.data.reciever, this.props.data.myPet, this.props.data.otherPet);
                } else {
                    this.getDatas(this.props.data.sender, this.props.data.myPet, this.props.data.otherPet);
                }
            }
            if (this.props.used === 'fin') {
                if (this.props.data.sender === auth.currentUser.uid) {
                    this.getDatas(this.props.data.reciever, this.props.data.myPet, this.props.data.otherPet);
                } else {
                    this.getDatas(this.props.data.sender, this.props.data.myPet, this.props.data.otherPet);
                }
                this.getRates();
            }
        });
        if (this.props.used === 'pen' && this.props.data) {
            this.setView(this.props.data.breedID);
        }
    }

    handleFeedback(a) {
        if (this.props.used === 'fin' || this.props.used === 'onh') {
            this.complete()
        } else if (this.props.used === 'pen') {
            this.decline(a);
        } else if (this.props.used === 'req') {
            this.cancel(a);
        }
    }
    componentWillUnmount() {
        this.setState({ pet: null, other_pet: null })
    }
    render() {
        return (
            <>
                {this.state.pet && <VerticalTimelineElement
                    className="vertical-timeline-element--work"
                    contentStyle={{ padding: '1vh 2vh', background: "var(--boColor)", color: ' var(--blaclk)', borderTop: '.35vh solid var(--blaclk)' }}
                    contentArrowStyle={{ borderRight: '1.5vh solid var(--boColor)' }}
                    date={this.state.duration}
                    iconStyle={{ background: "var(--blaclk)", color: '#fff' }}
                    icon={<IC1.FaPaw />}
                >
                    {(this.props.used !== 'req' && this.props.used !== 'fin') && <Link className='postImg'
                        to={this.props.user
                            ?
                            (this.state.owner.uid === auth.currentUser.uid
                                ? { pathname: `/profile` }
                                : { pathname: `/profile/${this.state.owner.uid}`, state: { fromUserID: `${this.state.owner.uid}` } })
                            : { pathname: `/profile/${this.state.owner.uid}` }
                        }>
                        {this.state.owner.profile ? <div style={{ zoom: "1.35" }} className='dp-wrapper'>
                            <img className='adProp' src={this.state.owner.profile} alt='dp' />
                            {this.state.status <= 3 && <div className='isOnline'></div>}
                        </div> : <div style={{ backgroundColor: this.state.owner.bgColor, zoom: "1.35" }} className='dp-wrapper' >
                            {this.state.owner.first_name !== undefined && this.state.owner.first_name[0]}
                            {this.state.status <= 3 && <div className='isOnline'></div>}
                        </div>}
                        <p className='postName breed'>
                            {this.state.owner.first_name + ' '}  {this.state.owner.middle_name !== undefined && !(this.state.owner.middle_name.replace(/\s/g, "").length <= 0) && this.state.owner.middle_name[0] + '. '} {this.state.owner.last_name}
                            {this.state.owner.type === 'pet-breeder' && <span className='posterTyped petb'>{this.state.owner.type}</span>}
                            {this.state.owner.type === 'veterinarian' && <span className='posterTyped vet'>{this.state.owner.type}</span>}
                            {this.state.owner.type === 'pet-owner' && <span className='posterTyped peto'>{this.state.owner.type}</span>}
                        </p>
                    </Link>}
                    <div className='breed_desc_warrper'>
                        <div className='breed_desc'>
                            {this.props.used === 'req' && <>You sent a request to breed your {this.state.pet.breed} {this.state.pet.species}
                                <a href={`/pets/${this.state.pet.PetId}`}>{`(${this.state.pet.name})`}</a>to
                                <a href={`/profile/${this.state.owner.uid}`}>{this.state.owner_name}</a>'s {this.state.other_pet.breed} {this.state.pet.species}
                                <a href={`/pets/${this.state.other_pet.PetId}`}>{`(${this.state.other_pet.name})`}</a>
                            </>}
                            {this.props.used === 'pen' && <>Sent you a request to breed your {this.state.pet.breed} {this.state.pet.species}
                                <a href={`/pets/${this.state.pet.PetId}`}>{`(${this.state.pet.name})`}</a>to
                                {this.state.owner.gender === 'Male' ? ' his ' : ' her '} {this.state.other_pet.breed} {this.state.pet.species}
                                <a href={`/pets/${this.state.other_pet.PetId}`}>{`(${this.state.other_pet.name})`}</a>
                            </>}
                            {this.props.used === 'onh' && <>Breeding in progress within your {this.state.owner.uid !== this.state.pet.owner ? <>
                                {this.state.pet.breed} {this.state.pet.species}
                                <a href={`/pets/${this.state.pet.PetId}`}>{`(${this.state.pet.name})`}</a> </>
                                : <>{this.state.other_pet.breed} {this.state.pet.species}
                                    <a href={`/pets/${this.state.other_pet.PetId}`}>{`(${this.state.other_pet.name})`}</a>
                                </>}
                                and <strong>{this.state.owner_name}</strong>'s {this.state.owner.uid === this.state.pet.owner ? <>
                                    {this.state.pet.breed} {this.state.pet.species}
                                    <a href={`/pets/${this.state.pet.PetId}`}>{`(${this.state.pet.name})`}</a> </>
                                    : <>{this.state.other_pet.breed} {this.state.pet.species}
                                        <a href={`/pets/${this.state.other_pet.PetId}`}>{`(${this.state.other_pet.name})`}</a>
                                    </>}
                            </>}
                            {this.props.used === 'fin' && <>
                                Breeding complete within your {this.state.owner.uid !== this.state.pet.owner ? <>
                                    {this.state.pet.breed} {this.state.pet.species}
                                    <strong>{`(${this.state.pet.name})`}</strong> </>
                                    : <>{this.state.other_pet.breed} {this.state.pet.species}
                                        <strong>{`(${this.state.other_pet.name})`}</strong>
                                    </>}
                                and <strong>{this.state.owner_name}</strong>'s {this.state.owner.uid === this.state.pet.owner ? <>
                                    {this.state.pet.breed} {this.state.pet.species}
                                    <strong>{`(${this.state.pet.name})`}</strong> </>
                                    : <>{this.state.other_pet.breed} {this.state.pet.species}
                                        <strong>{`(${this.state.other_pet.name})`}</strong>
                                    </>}
                                <p><strong>Finished by: </strong>{this.state.finByName}</p>
                                <p><strong>Ratings: </strong></p>
                                {this.state.rating ? <>
                                    <BeautyStars
                                        inactiveColor="var(--borderColor)"
                                        activeColor="var(--primaryTextColor)"
                                        value={this.state.rating.value}
                                        size='3vh'
                                        editable={false}
                                    />
                                    <strong>You</strong> rated <strong>{this.state.owner_name}</strong>'s {this.state.owner.uid === this.state.pet.owner ? <>
                                        {this.state.pet.breed} {this.state.pet.species}
                                        <a href={`/pets/${this.state.pet.PetId}`}>{`(${this.state.pet.name})`}</a> </>
                                        : <>{this.state.other_pet.breed} {this.state.pet.species}
                                            <a href={`/pets/${this.state.other_pet.PetId}`}>{`(${this.state.other_pet.name})`}</a>
                                        </>}
                                    <p className='descRate'><strong>" </strong>{this.state.rating.desc}<strong> "</strong></p>
                                </>
                                    : <p className='unrated'>Unrated</p>}

                                {this.state.rating2 ? <>
                                    <BeautyStars
                                        inactiveColor="var(--borderColor)"
                                        activeColor="var(--primaryTextColor)"
                                        value={this.state.rating2.value}
                                        size='3vh'
                                        editable={false}
                                    /><strong>{this.state.owner_name}</strong> rated your {this.state.owner.uid !== this.state.pet.owner ? <>
                                        {this.state.pet.breed} {this.state.pet.species}
                                        <a href={`/pets/${this.state.pet.PetId}`}>{`(${this.state.pet.name})`}</a> </>
                                        : <>{this.state.other_pet.breed} {this.state.pet.species}
                                            <a href={`/pets/${this.state.other_pet.PetId}`}>{`(${this.state.other_pet.name})`}</a>
                                        </>}
                                    <p className='descRate'><strong>" </strong>{this.state.rating2.desc}<strong> "</strong></p>
                                </>
                                    : <p className='unrated'>Unrated</p>}

                            </>}
                            {this.props.used === 'dec' && <>{this.props.data.status === 'cancelled' ? 'You cancelled your breeding request ' : 'Breeding request has been declined '} within your {this.state.owner.uid !== this.state.pet.owner ? <>
                                {this.state.pet.breed} {this.state.pet.species}
                                <a href={`/pets/${this.state.pet.PetId}`}>{`(${this.state.pet.name})`}</a> </>
                                : <>{this.state.other_pet.breed} {this.state.pet.species}
                                    <a href={`/pets/${this.state.other_pet.PetId}`}>{`(${this.state.other_pet.name})`}</a>
                                </>}
                                and <a href={`/profile/${this.state.owner.uid}`}>{this.state.owner_name}</a>'s {this.state.owner.uid === this.state.pet.owner ? <>
                                    {this.state.pet.breed} {this.state.pet.species}
                                    <a href={`/pets/${this.state.pet.PetId}`}>{`(${this.state.pet.name})`}</a> </>
                                    : <>{this.state.other_pet.breed} {this.state.pet.species}
                                        <a href={`/pets/${this.state.other_pet.PetId}`}>{`(${this.state.other_pet.name})`}</a>
                                    </>}
                                {this.props.data.Res && <p><strong>Reason</strong> : {this.props.data.Res}</p>}
                            </>}
                        </div>
                        <div className='breed_desc_btns'>
                            {this.props.used === 'req' && <button onClick={() => { this.setState({ feedback: true }) }} className='tableData_btn dangerBtn'>Cancel</button>}
                            {this.props.used === 'pen' && <>
                                <button onClick={() => { this.accept() }} className='tableData_btn successBtn'>Accept</button>
                                <button onClick={() => { this.setState({ feedback: true }) }} className='tableData_btn dangerBtn'>Decline</button>
                            </>}
                            {this.props.used === 'onh' && <button onClick={() => { this.setState({ feedback: true }) }} className='tableData_btn successBtn'>Finished</button>}
                            {this.props.used === 'fin' && !this.state.rating && <button onClick={() => { this.setState({ feedback: true }) }} className='tableData_btn successBtn'>Give Feedback to {this.state.owner.first_name}'s Pet </button>}
                        </div>
                    </div>
                    {this.props.used === 'dec' && <p>{this.state.duration2}</p>}
                </VerticalTimelineElement>}
                {this.state.feedback && <Feedback used={this.props.used} breedID={this.props.data.breedID} fin={(a) => { this.handleFeedback(a) }} pet={this.state.pet.owner === auth.currentUser.uid ? this.state.other_pet : this.state.pet} hideFeed={() => { this.setState({ feedback: false }) }} />}
            </>
        )
    }
}

export default BreedList
