import axios from "axios";

const checkIfPostExists = async (postID) => {
    try {
        const request = axios.get(`/postExistsInConversation/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getConvo = async (convoID) => {
    try {
        const request = axios.get(`/conversation/${convoID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getConvos = async () => {
    try {
        const request = axios.get(`/conversations`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const getConvoFromPost = async (postID) => {
    try {
        const request = axios.get(`/getConvoFromPost/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export default { checkIfPostExists, getConvo, getConvos, getConvoFromPost };
