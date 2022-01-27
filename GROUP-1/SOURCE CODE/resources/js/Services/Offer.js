import axios from "axios";

const checkIfOfferAlreadyExists = async (postID, userID) => {
    try {
        const request = axios.post(
            `/offerExists/post/${postID}/user/${userID}`
        );
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getPostOffers = async (postID) => {
    try {
        const request = axios.get(`/postOffers/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const acceptOffer = async (offerID) => {
    try {
        const request = axios.put(`/acceptOffer/${offerID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getOffer = async (offerID) => {
    try {
        const request = axios.get(`/getOffer/${offerID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getOfferOfAuthUser = async (postID, otherUserID) => {
    try {
        const request = axios.get(
            `/getOfferOfAuthUser/${postID}/${otherUserID}`
        );
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getOfferCount = async (postID) => {
    try {
        const request = axios.get(`/getOfferCount/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getOfferToUser = async (userID) => {
    try {
        const request = axios.get(`/getOfferToUser/${userID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export default {
    checkIfOfferAlreadyExists,
    getPostOffers,
    acceptOffer,
    getOffer,
    getOfferOfAuthUser,
    getOfferCount,
    getOfferToUser,
};
