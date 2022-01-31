import React, { Component } from 'react'
import firebase from '../../config/firebase'
import './AdmHome.css';
import AddPost from '../../components/AddPost.js';
import Post from '../../components/Post.js';
class AdmHome extends Component {
    constructor(props) {
        super(props)

        this.state = {
            post: []
        }
    }

    getPost() {
        firebase.collection("Post").where('deleted', '==', false).orderBy('timestamp', 'desc').onSnapshot((snaps) => {
            this.setState({ post: snaps.docs.map(doc => doc.data()) })
        }
        )
    }

    componentDidMount() {
        this.interval = setInterval(() => {
            this.getPost();
        })
    }
    render() {
        return (
            <div className='admin-container'>
                <AddPost />
                {this.state.post ? <div className="post-admin"> <Post post={this.state.post} /></div> : <div className="NoPost">No post available</div>}
            </div>
        )
    }
}

export default AdmHome
