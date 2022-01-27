import axios from "axios";

const getUser = async (userID) => {
    try {
        const request = axios.get(`/user/${userID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getAuthUser = async () => {
    const request = axios.get(`/currentUser`);
    const response = await request;
    return response.data;
};

const getEncryptedUserId = async (userID) => {
    const request = axios.post(`/encrypt/${userID}`);
    const response = await request;
    return response.data;
};

const getName = async (userID) => {
    try {
        const request = axios.get(`/name/${userID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getPromotion = async (userID) => {
    try {
        const request = axios.get(`/promotion/${userID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getOffenseLevel = async (userID) => {
    try {
        const request = axios.get(`/offenseLevel/${userID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export default {
    getUser,
    getAuthUser,
    getEncryptedUserId,
    getName,
    getPromotion,
    getOffenseLevel,
};
