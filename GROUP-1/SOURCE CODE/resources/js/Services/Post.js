import axios from "axios";

const getAll = async () => {
    const request = axios.get(route("post.index"));
    const response = await request;
    return response.data;
};

const getAuthUserPosts = async () => {
    const request = axios.get("/getAuthUserPosts");
    const response = await request;
    return response.data;
};

const getUserPosts = async (userID) => {
    try {
        const request = axios.get(`/getUserPosts/${userID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getPostAuthor = async (postID) => {
    try {
        const request = axios.get(`/getPostAuthor/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getPost = async (postID) => {
    try {
        const request = axios.get(`/getPost/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const exists = async (postID) => {
    try {
        const request = axios.get(`/postExists/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export default {
    getAll,
    getAuthUserPosts,
    getUserPosts,
    getPostAuthor,
    getPost,
    exists,
};
