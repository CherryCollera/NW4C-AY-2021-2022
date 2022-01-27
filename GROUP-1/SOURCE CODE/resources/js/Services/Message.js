import axios from "axios";

const getMessages = async (convoID) => {
    const request = axios.get(`/messages/${convoID}`);
    const response = await request;
    return response.data;
};

const getLastMessage = async (convoID) => {
    const request = axios.get(`/lastMessage/${convoID}`);
    const response = await request;
    return response.data;
};

const getMessagesOfUser = async () => {
    const request = axios.get(`/getMessagesOfUser`);
    const response = await request;
    return response.data;
};

export default { getMessages, getLastMessage, getMessagesOfUser };
