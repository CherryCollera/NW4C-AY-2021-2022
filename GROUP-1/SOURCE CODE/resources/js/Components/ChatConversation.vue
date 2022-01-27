<template>
    <a v-if="matchesSearch(search, getName())" @click="showConvo(convo, getSender())" class="w-full hover:bg-gray-100 border-b border-gray-300 px-3 py-2 cursor-pointer flex items-center text-sm focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
        <img class="h-10 w-10 rounded-full object-cover"
        :src="getProfilePhoto()"
        alt="username" />
        <div class="w-full pb-2">
            <div class="flex justify-between">
                <span class="block ml-2 font-semibold text-base text-gray-600 ">{{ getName() }}</span>
                <span class="block ml-2 text-sm text-gray-600">{{ getDate() }}</span>
            </div>
            <span class="block ml-2 text-sm text-gray-600">{{ getContent() }}</span>
        </div>
    </a>
</template>

<script>
import UserServices from '@services/User'
import DateHelpers from '@utils/date-helpers'

export default {

    props: ['convo', 'showConvo', 'search'],

    data(){
        return{
            authUser: this.$page.props.authUser,
            sender: null,
            receiver: null,
            lastMessage: this.convo.message[this.convo.message.length - 1],
        }
    },

    methods:{

        matchesSearch(search, name){

            // if matches
            this.$emit('messages-search-matches')

            if(search === '' || name === '') return true

            if(name.toLowerCase().indexOf(search.toLowerCase()) > -1) return true && this.lastMessage

            // If no matches
            this.$emit('messages-no-search-matches')
            return false
        },

        getSender(){
            if(this.isNull()) return ''

             if(this.isUserSender()){
                return this.receiver
            }else{
                return this.sender
            }
        },

        getDate(){
            if(this.isNull()) return ''
            
            return DateHelpers.getTimeAgo(this.lastMessage.created_at);
        },

        getContent(){
            if(this.isNull()) return ''
            
            if(this.lastMessage.content === 'J0bZVYAygIsovtriXs23uXejc6bU85BjWQuTM8aeEptFCEeDlWmB5Uh41LoqhNaBQAV8EGkP6aRkcW8YE5ed2J8ygrk78yyM6xSxzRBzIwCVvXZHEDSnj96d0sAhLlzqaSMmPUsL4QIyqQbO0BxHqCCo65iNXzsWpP7KvTmq4LMtMPnY3YLA4a6EYixkgBEddE0XY3po2MjnpUgODprZkzJNgS3l9A4KOQnabCEjw2mCuIYKPZrCAB1VGTLYnj8H') return 'Started Barter'
            
            if(this.lastMessage.content === 'Y44OpG1tkc6XXe1eJD0U6zkjpz2WSg5EQwUqCzktqNFLQyZZnnjMcHo1NuWIg3TgXZ8y6FASjOZX97NR5NJ4IslpmFeao6ZK3fDJISMyQ1wdcJjdnIqSudjbwSxEa6H6W0sHli5Dr1eLASnhfNUuqLd0qfrXtQCaJsuNMcsXQIqMHSNY8SruMpj4gCANUmbiHMezuYcSF4Ir3WHzgkbK7vmbeTkMrT8lGoE4v8roHvH5TAK1UAQoODgK8fGzeJk3') return 'Deleted Post'

            if(this.lastMessage.content === 'lCKgxW4lj8cUGg2nnqGziCsw7pp9uJo4xHFOIS9THC0r5OOdhZZvTL8HJNzUXUv7qajYPqcw9VY4HrEjox0NcR13jp8dSXpaUYsh8yxEAtvCxQ6HGbNKTRe2kvJBT16XBTIjtIcM669bPbuxs27VvMtThBkZfznEgRcZvP3sZH5Eq1g9VbPsBVSb4kdaAGA41vC6xmfW7YZFM8MWY0QrjnzoMiwSrAf0hCE5XlErHZpCH9IRI913yDx7m5S1PBjO') return 'Barter Done'

            if(this.lastMessage.post_id) return 'Accepted offer'

            if(this.lastMessage.image_path) return 'Sent a photo'

            return this.lastMessage.content
        },

        getName(){
            if(this.isNull()) return ''

            return this.isUserSender() ? this.receiver.name : this.sender.name
        },

        getProfilePhoto(){

            if(this.isNull()) return ''

            if(this.isUserSender()){
                return this.fetchProfilePhoto(this.receiver)
            }else{
                return this.fetchProfilePhoto(this.sender)
            }

        },

        fetchProfilePhoto(user){
            if(user.profile_photo_path){
                return '/storage/' + user.profile_photo_path
            }else{
                return `https://ui-avatars.com/api/?name=${user.name}&color=059669&background=ECFDF5`
            }
        },

        isUserSender(){
            if(this.isNull()) return ''
            return this.authUser.id === this.sender.id ? true : false
        },

        isNull(){
            return this.sender === null || this.receiver === null || this.lastMessage === null ? true : false
        },

        async getUsers(){
            this.sender = await UserServices.getUser(this.convo.sender_user_id)
            this.receiver = await UserServices.getUser(this.convo.receiver_user_id)
        }
    },

    created(){
        this.getUsers()
    },
}
</script>