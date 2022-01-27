import axios from "axios";

const getFeedback = async (postID) => {
    try {
        const request = axios.get(`/getFeedback/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getUserFeedbacks = async (userID) => {
    try {
        const request = axios.get(`/getUserFeedbacks/${userID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getAllFeedback = async (userID) => {
    try {
        const request = axios.get(`/getAllFeedback/${userID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export default { getFeedback, getUserFeedbacks, getAllFeedback };
