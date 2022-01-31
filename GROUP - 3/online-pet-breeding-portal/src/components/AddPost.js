import React, { Component } from 'react'
import './AddPost.css'
import * as bsIcons from 'react-icons/bi'
import { AiOutlineTeam } from 'react-icons/ai'
import firebase, { auth, storage } from "../config/firebase";
import NotifDiv from './NotifDiv'

class AddPost extends Component {
    constructor(props) {
        super(props);
        this.picRef = React.createRef();
        this.state = {
            userData: [],
            previewImg: '',
            imgToUp: '',
            desc: '',
            tag: '',
            status: 0,
            posty: [
                { value: 'public', label: 'Public', icon: <bsIcons.BiGlobe /> },
                { value: 'friend', label: 'Friend', icon: <AiOutlineTeam /> },
            ],
            sel: 1,
            blovk: false,
            adpB: false,
        }
    }

    showPt(e) {
        this.setState({
            blovk: e,
        })
    }
    hidePt() {
        this.setState({
            blovk: false,
            sel: 1,
            desc: '',
            tag: '',
            imgToUp: '',
            previewImg: '',
            adpB: false,
        })
    }

    onImgChange(e) {
        const reader = new FileReader();
        reader.onload = () => {
            if (reader.readyState === 2) {
                this.setState({ previewImg: reader.result })
            }
        }
        reader.readAsDataURL(e.target.files[0]);
        this.setState({ imgToUp: e.target.files[0] });
    }
    handlePost(a = this.state.imgToUp, b = this.state.desc, c = this.state.tag) {
        if (!this.props.UD) {
            c = 'Announcement';
        }
        const uids = auth.currentUser.uid;
        const UploadImg = storage.ref(`images/${uids}/${a.name}`).put(a);
        if (a !== '') {
            UploadImg.on(
                "state_changed",
                snapshot => {
                    if (snapshot.bytesTransferred === snapshot.totalBytes) {
                        const postRef = firebase.collection("Post");
                        try {
                            postRef.add({
                                postById: uids,
                                desc: b,
                                tags: c,
                                deleted:false,
                                timestamp: new Date()
                            }).then(post => {
                                console.log(snapshot);
                                storage
                                    .ref(`images/${uids}/`)
                                    .child(a.name)
                                    .getDownloadURL()
                                    .then(url => {
                                        firebase.doc("Post/" + post.id).set({ imgLink: url, postId: post.id, }, { merge: true })
                                    })
                            })
                        } catch (error) {
                            console.log("Error in creating post", error);
                        }
                    }
                },
                error => {
                    console.log(error);
                }
            )
        } else {
            const postRef = firebase.collection("Post");
            try {
                postRef.add({
                    postById: uids,
                    desc: b,
                    tags: c,
                    imgLink: a,
                    timestamp: new Date()
                }).then(post => {
                    firebase.doc("Post/" + post.id).set({ postId: post.id, }, { merge: true })
                })
            } catch (error) {
                console.log("Error in creating post", error);
            };
        }
        this.hidePt();
        this.setState({ notify: true })
    }

    render() {
        return (
            <>
                <div className='log-in addSD'>
                    <div className='tpAdp'>
                        {this.props.UD
                            ? (this.props.UD.profile ? <div className='dp-wrapper' >
                                <img className='adProp' src={this.props.UD.profile} alt='dp' />
                                <div className='isOnline'></div>
                            </div> : <div style={{ backgroundColor: this.props.UD.bgColor }} className='dp-wrapper' >
                                {this.props.UD.first_name !== undefined && this.props.UD.first_name[0]}
                                <div className='isOnline'></div>
                            </div>)
                            : <div style={{ backgroundColor: "var(--primaryColor)" }} className='dp-wrapper' >
                                A
                            </div>
                        }
                        <input type='text' readOnly onFocus={() => { this.showPt(true) }} className='adInp'
                            placeholder={this.props.UD ? (this.props.UD.first_name ? "What's on your mind, " + this.props.UD.first_name : ' ') : 'Write an announcements'} />
                    </div>
                    <div className='btAdp'>
                        <button className='btn-log postdia' onClick={() => { this.showPt(true) }} type='button' >{this.props.UD ? 'Create Post' : 'Add Announcements'}</button>
                        <a href='/breed' className='btn-log postdia'  >Breeding</a>
                    </div>
                </div>
                {!this.state.blovk && this.state.notify && <NotifDiv />}
                {
                    this.state.blovk &&
                    <>
                        <div id='ShowPTD' scroll="no" className='log-in'>
                            <div className='tpAdp'>
                                {this.props.UD
                                    ? (this.props.UD.profile ? <div className='dp-wrapper' >
                                        <img className='adProp' src={this.props.UD.profile} alt='dp' />
                                        <div className='isOnline'></div>
                                    </div> : <div style={{ backgroundColor: this.props.UD.bgColor }} className='dp-wrapper' >
                                        {this.props.UD.first_name !== undefined && this.props.UD.first_name[0]}
                                        <div className='isOnline'></div>
                                    </div>)
                                    : <div style={{ backgroundColor: "var(--primaryColor)" }} className='dp-wrapper' >
                                        A
                                    </div>
                                }

                                <div className='posTy'>
                                    {this.props.UD
                                        ?
                                        <p className='userName'>{this.props.UD.first_name + ' '}  {this.props.UD.middle_name !== '' && this.props.UD.middle_name !== undefined && this.props.UD.middle_name[0] + '. '} {this.props.UD.last_name}</p>
                                        :
                                        <p className='userName'>Admin</p>}
                                </div>
                            </div>
                            <textarea onChange={(e) => { this.setState({ desc: e.target.value }) }} id='adInp' type='text' className='adInp' placeholder={this.props.UD ? (this.props.UD.first_name ? "What's on your mind, " + this.props.UD.first_name : ' ') : 'Write Announcements'} ></textarea>
                            <div className='RegImgDiv'>
                                <div className='RegImg_wrapper' onClick={(e) => { this.picRef.current.click(); }}>
                                    <input style={{ display: 'none' }} accept="image/*" type='file' onChange={(e) => { this.onImgChange(e) }} ref={this.picRef} />
                                    {this.state.previewImg !== '' ? <img className='prevImg' src={this.state.previewImg} alt='dp' />
                                        : <span>Add Image <bsIcons.BiImageAdd /></span>}
                                </div>
                            </div>
                            {this.props.UD && <><div className='hr'></div>
                                <div className='tag-wrapper'>Tags:
                                    <div className='taag'>
                                        <label className='tags'><input type='radio' onChange={(e) => { this.setState({ tag: e.target.value }) }} value='find' name='tags' />Find Breed</label>
                                        <label className='tags'><input type='radio' onChange={(e) => { this.setState({ tag: e.target.value }) }} value='show' name='tags' />Show Off</label>
                                        <label className='tags'><input type='radio' onChange={(e) => { this.setState({ tag: e.target.value }) }} value='celeb' name='tags' />Celebration</label>
                                        <label className='tags'><input type='radio' onChange={(e) => { this.setState({ tag: e.target.value }) }} value='trade' name='tags' />Trade</label>
                                    </div>
                                </div></>}
                            <div className='hr'></div>
                            <div className='btAdp'>
                                <button onClick={() => { this.handlePost() }} className={(this.state.desc.replace(/\s/g, "").length <= 0 && this.state.previewImg.replace(/\s/g, "").length <= 0) ? 'btn-log btn_disabled' : 'btn-log'} type='button' >Post</button>
                                <div style={{ width: "10vw" }} />
                                <button className='btn-log postClose' onClick={() => { this.hidePt() }} type='button' >Close</button>
                            </div>
                        </div>
                        <div scroll="no" className='adPtB'></div></>
                }
            </>
        )
    }
}

export default AddPost

